<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('user.invoice.index');
    }

    public function create()
    {
        return view('user.invoice.create');
    }
    public function financialReport()
    {
        return view('user.invoice.financial-report');
    }

    public function manualInvoice()
    {
        $customers = Customer::all();

        return view('user.invoice.manual-subscription', compact('customers'));
    }

    public function creditInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'customer_id' => 'required',
            'call_center' => 'required|numeric',
            'virtual_support' => 'required|numeric',
            'general_support' => 'required|numeric',
            'frequency' => 'required',
        ]);

        $customer = Customer::find($request->customer_id);
        $customerUserId = $customer->user_id;
        
        $reference =  Subscription::generateTrx(10);
        $now = Carbon::now();

        DB::beginTransaction();

         $subscription = Subscription::create([
            'user_id' => $customerUserId,
            'payment_gateway_ref' => 'Manual-ref'.$reference,
            'status' => 'successful',
            'reference' => 'ref'.$reference,
            //'payment_method' => $response['responseBody']['channel'],
            'currency' => 'NGN',
            'amount' => $request->amount,
            'virtual_assistance_points' => $request->virtual_support,
            'call_service_points' => $request->call_center,
            'general_support_points' => $request->general_support,
        ]);

        // dd($response);
        $frequency = $request->frequency;
        $subEnddate = Carbon::parse($customer->subscription_date);
        $now = Carbon::now();
        $newEndDate  = $now->copy();

        switch ($frequency) {
            case 'monthly':
                $newEndDate->addMonth();
                break;
            case 'yearly':
                $newEndDate->addYear();
                break;
            default:
                $newEndDate  = $now->copy();
                break;
        }
        // $customer->update([
        //     'subscription_date' => $now,
        //     'subscription_due_date' => $newEndDate,
        // ]);


        $baseVirtualPoints = $subscription->virtual_assistance_points ?? 0;
        $baseCallPoints = $subscription->call_service_points ?? 0;
        $baseGeneralPoints = $subscription->general_support_points ?? 0;

        // Check if renewal is within 48 hours of current subscription end date
        $subEndDate = Carbon::parse($customer->subscription_due_date);
        $shouldApplyBonus = $now->diffInHours($subEndDate) <= 48;

        // Calculate points with 30% bonus if applicable
        $virtualPoints = $baseVirtualPoints;
        $callPoints = $baseCallPoints;
        $generalPoints = $baseGeneralPoints;

        if ($shouldApplyBonus) {
            $virtualPoints += $baseVirtualPoints * 0.3;
            $callPoints += $baseCallPoints * 0.3;
            $generalPoints += $baseGeneralPoints * 0.3;
        }

        // Update customer subscription and points
        $customer->update([
            'is_subscribed' => 1,
            'subscription_date' => $now,
            'subscription_due_date' => $newEndDate,
            'virtual_assistance_points' => ($customer->virtual_assistance_points ?? 0) + $virtualPoints,
            'call_service_points' => ($customer->call_service_points ?? 0) + $callPoints,
            'general_support_points' => ($customer->general_support_points ?? 0) + $generalPoints,
        ]);

        DB::commit();

        return back()->with('success', 'Subscription created successfully.');
    }

    public function getSubscription()
    {
        $subscriptions = Subscription::with(['user', 'customer'])
            //->select(['amount', 'status', 'reference', 'payment_gateway_ref', 'email'])
            ->latest()
            ->get();
            return response()->json(
                [
                    'success' => true,
                    'subscriptions' => $subscriptions
                ]
                );
    }

    public function getSingleInvoice($id)
    {
        $data = Subscription::with(['user', 'customer'])->findOrFail($id);
        return view('user.invoice.single-invoice', compact('data'));
    }
}
