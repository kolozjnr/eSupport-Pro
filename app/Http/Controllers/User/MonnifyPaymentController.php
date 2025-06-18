<?php

namespace App\Http\Controllers\User;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\MonnifyService;
use App\Http\Controllers\Controller;

class MonnifyPaymentController extends Controller
{
    protected $monnify;

    public function __construct(MonnifyService $monnify)
    {
        $this->monnify = $monnify;
    }

    public function pay(Request $request)
    {
        $userId = auth()->user()->id;
        $customerId = auth()->user()->getCustomerId();
        $reference =  Subscription::generateTrx(10);
        try {
            $response = $this->monnify->initializeTransaction([
            'amount' => $request->amount,
            'name' => auth()->user()->lname ?? 'Guest',
            'email' => auth()->user()->email ?? 'guest@example.com',
            'reference' => $reference,
            // 'reference' => $reference,
            //'description' => 'Payment for Order #' . $reference,
            'redirect_url' => route('monnify.callback')
        ]);
        //dd($response);
        //Payment failed to initialize. Array to string conversion (Connection: mysql, SQL: insert into `subscriptions` (`user_id`, `customer_id`, `payment_gateway_ref`, `paymentReference`, `reference`, `amount`, `status`, `updated_at`, `created_at`) values (7, ?, MNFY|10|20250618220042|000102, vYX8QqhUiM, ?, 10000, pending, 2025-06-18 21:00:40, 2025-06-18 21:00:40))



         $transaction = Subscription::create([
                'user_id' => $userId,
                'customer_id' => $customerId,
                'payment_gateway_ref' => $response['responseBody']['transactionReference'],
                'paymentReference' => $response['responseBody']['paymentReference'],
                'reference' => $response,
                'amount' => $request->amount,
                'status' => 'pending',
                //'reference' => InitializeDeposit::generateTrx(10),
            ]);

        if ($response['requestSuccessful']) {
            return redirect($response['responseBody']['checkoutUrl']);
        }
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed to initialize. ' . $e->getMessage());
        }

        

        return back()->with('error', 'Payment failed to initialize.');
    }

    public function callback(Request $request)
    {
        $transactionReference = $request->get('paymentReference');

        $response = $this->monnify->verifyTransaction($transactionReference);

        if (isset($response['responseBody']['paymentStatus']) && $response['responseBody']['paymentStatus'] === 'PAID') {
            // ✅ Mark order as paid
            // For example: Order::where('reference', $transactionReference)->update(['status' => 'paid']);

            return view('monnify.success', ['data' => $response['responseBody']]);
        } else {
            // ❌ Payment not successful
            return view('monnify.failed', ['message' => 'Payment not verified']);
        }
    }


    


    //     public function callback(Request $request)
    //     {
    //         // Handle success callback here
    //         // You can also verify the transaction if needed
    //         \Log::info('Monnify callback:', $request->all());
    //         return view('monnify.callback', ['data' => $request->all()]);
    //     }

    //     public function verifyTransaction($transactionReference)
    // {
    //     $token = $this->getAccessToken();

    //     $response = Http::withToken($token)
    //         ->get("{$this->baseUrl}/api/v2/transactions/{$transactionReference}");

    //     return $response->json();
    // }

}
