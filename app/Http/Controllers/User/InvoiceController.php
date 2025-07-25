<?php

namespace App\Http\Controllers\User;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function getSubscription()
    {
        $subscriptions = Subscription::with(['customer'])
            ->select(['amount', 'status', 'reference', 'payment_gateway_ref', 'email'])
            ->get();
            return response()->json(
                [
                    'success' => true,
                    'subscriptions' => $subscriptions
                ]
                );
    }
}
