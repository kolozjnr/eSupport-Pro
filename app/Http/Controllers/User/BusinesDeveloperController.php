<?php

namespace App\Http\Controllers\User;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerNotificationMail;
use Illuminate\Support\Facades\Validator;

class BusinesDeveloperController extends Controller
{
   public function bussinesDeveloperDashboard()
    {
        $user = auth()->user();
        if(auth()->user()->hasRole('businessdeveloper')){
            $totalCustomers = Customer::where('business_developer_id', $user->id)->count();
            $activeCustomers = Customer::where('business_developer_id', $user->id)
                ->where('is_subscribed', 1)->count();
            $inactiveCustomers = Customer::where('business_developer_id', $user->id)
                ->where('is_subscribed', 0)->count();

            $chartData = Customer::where('business_developer_id', $user->id)
                ->where('is_subscribed', 1)
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            $chartDataComplete = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $monthYear = $date->format('Y-m');
                $monthName = $date->format('M Y');
                
                $count = Customer::where('business_developer_id', $user->id)
                    ->where('is_subscribed', 1)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
                    
                $chartDataComplete[] = [
                    'period' => $monthName,
                    'month' => $date->month,
                    'year' => $date->year,
                    'count' => $count
                ];
            }

            return response()->json([
                'totalCustomers' => $totalCustomers,
                'activeCustomers' => $activeCustomers,
                'inactiveCustomers' => $inactiveCustomers,
                'chartData' => $chartData,
                'chartDataComplete' => $chartDataComplete // Complete 12 months with 0 counts included
            ]);
        }
        
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function sendEmails()
    {
        $user = auth()->user();
        $bussinesId = $user->businessDeveloper->id;
        $customers = Customer::with('user')->where('business_developer_id', $bussinesId)->get();
        return view('user.business.send-emails-customers', compact('customers'));
    }

    public function getAllMyCustomers()
    {
        $user = auth()->user();
        $bussinesId = $user->businessDeveloper->id;
        $customers = Customer::with('user')->where('business_developer_id', $bussinesId)->get();

        return response()->json([
            'customers' => $customers
        ]);
    }

   public function sendSingleEmail(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->businessDeveloper) {
            return response()->json(['error' => 'Business developer not found'], 400);
        }
        
        $businessId = $user->businessDeveloper->id;

        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Find the specific customer by email and business developer
            $customer = Customer::where('business_developer_id', $businessId)
                ->whereHas('user', function($query) use ($request) {
                    $query->where('email', $request->email);
                })
                ->with('user')
                ->first();

            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            Mail::to($request->email)->send(new CustomerNotificationMail(
                $request->subject,
                $request->message,
                $customer
            ));
            
            return back()->with('success', 'Email sent sucessfully');
            
        } catch (\Exception $e) {
            \Log::error('Failed to send single email', [
                'email' => $request->email,
                'business_developer_id' => $businessId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }

  public function sendInactiveEmail(Request $request)
{
    $user = auth()->user();
    
    // Check if user has business developer relationship
    if (!$user->businessDeveloper) {
        return redirect()->back()->with('error', 'Business developer not found.');
    }
    
    $businessId = $user->businessDeveloper->id;

    $validator = Validator::make($request->all(), [
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $emailCount = 0;
        $failedEmails = [];
        
        Customer::where('business_developer_id', $businessId)
            ->where('is_subscribed', 0) // 0 = unsubscribed/inactive
            ->whereHas('user', function($query) {
                $query->whereNotNull('email');
            })
            ->with(['user:id,email,fname,lname']) // Added lname for email template
            ->chunk(100, function ($customers) use ($request, &$emailCount, &$failedEmails) {
                foreach ($customers as $customer) {
                    try {
                        Mail::to($customer->user->email)->queue(new CustomerNotificationMail(
                            $request->subject,
                            $request->message,
                            $customer
                        ));
                        $emailCount++;
                    } catch (\Exception $e) {
                        $failedEmails[] = $customer->user->email;
                        \Log::error('Failed to queue email for customer', [
                            'email' => $customer->user->email,
                            'error' => $e->getMessage(),
                            'customer_id' => $customer->id,
                            'user_id' => $customer->user->id
                        ]);
                    }
                }
            });

        // Log the activity
        \Log::info('Bulk email sent to inactive customers', [
            'business_developer_id' => $businessId,
            'emails_queued' => $emailCount,
            'failed_emails' => count($failedEmails),
            'subject' => $request->subject
        ]);

        $message = "Successfully queued {$emailCount} emails to inactive customers.";
        if (!empty($failedEmails)) {
            $message .= " " . count($failedEmails) . " emails failed to queue.";
        }

        return redirect()->back()->with('success', $message);

    } catch (\Exception $e) {
        \Log::error('Failed to send inactive customer emails', [
            'business_developer_id' => $businessId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()->with('error', 'Failed to send emails. Please try again.');
    }
}

public function sendAllCustomerEmail(Request $request)
{
    $user = auth()->user();
    $businessId = $user->businessDeveloper->id;

    $validator = Validator::make($request->all(), [
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $emailCount = 0;
        $failedEmails = [];
        
        Customer::where('business_developer_id', $businessId)
            // ->where('is_subscribed', 0)
            ->whereHas('user', function($query) {
                $query->whereNotNull('email');
            })
            ->with(['user:id,email,fname,lname']) // Only load needed user fields
            ->chunk(100, function ($customers) use ($request, &$emailCount, &$failedEmails) {
                foreach ($customers as $customer) {
                    try {
                        Mail::to($customer->user->email)->queue(new CustomerNotificationMail(
                            $request->subject,
                            $request->message,
                            $customer
                        ));
                        $emailCount++;
                    } catch (\Exception $e) {
                        $failedEmails[] = $customer->user->email;
                        \Log::error('Failed to queue email for customer', [
                            'email' => $customer->user->email,
                            'error' => $e->getMessage(),
                            'customer_id' => $customer->id,
                            'user_id' => $customer->user->id
                        ]);
                    }
                }
            });

        // Log the activity
        \Log::info('Bulk email sent to all customers', [
            'business_developer_id' => $businessId,
            'emails_queued' => $emailCount,
            'failed_emails' => count($failedEmails),
            'subject' => $request->subject
        ]);

        $message = "Successfully queued {$emailCount} emails.";
        if (!empty($failedEmails)) {
            $message .= " " . count($failedEmails) . " emails failed to queue.";
        }

        return redirect()->back()->with('success', $message);

    } catch (\Exception $e) {
        \Log::error('Failed to send customer emails', [
            'business_developer_id' => $businessId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()->with('error', 'Failed to send emails. Please try again.');
    }
}

    public function sendEmailsPost(Request $request)
    {
        $user = auth()->user();
        $bussinesId = $user->businessDeveloper->id;
        $customers = Customer::with('user')->where('business_developer_id', $bussinesId)->get();
        return view('user.business.send-emails-customers', compact('customers'));
    }

}
