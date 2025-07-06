<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\MonnifyService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        



         $transaction = Subscription::create([
                'user_id' => $userId,
                'customer_id' => $customerId,
                'payment_gateway_ref' => $response['responseBody']['transactionReference'],
                'paymentReference' => $response['responseBody']['paymentReference'],
                'reference' => $reference,
                'amount' => $request->amount,
                'payment_method' => 'Monnify',
                'virtual_assistance_points' => $request->virtual_assistance_points,
                'call_service_points' => $request->call_center_points,
                'general_support_points' => $request->general_support_points,
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
        $paymentReference = $request->get('paymentReference'); // YOUR reference
        $subscription = Subscription::where('paymentReference', $paymentReference)->first();
        $customerId = auth()->user()->getCustomerId();
        $customer = Customer::find($subscription->customer_id);

        if (!$subscription) {
            return response()->json(['error' => 'Payment reference not found.'], 404);
        }

        $transactionReference = $subscription->payment_gateway_ref; // MONNIFY's reference

        try {
            if ($subscription->status === 'successful') {
                throw new \Exception("Transaction already processed.");
            }

            $response = $this->monnify->verifyTransaction($transactionReference);

            if (
                isset($response['responseBody']['paymentStatus']) &&
                $response['responseBody']['paymentStatus'] === 'PAID'
            ) {
                //dd($response);
                $subscription->update([
                    'status' => 'successful',
                    'reference' => $response['responseBody']['paymentReference'],
                    //'payment_method' => $response['responseBody']['channel'],
                    'currency' => $response['responseBody']['currency'],
                    'amount' => $response['responseBody']['amountPaid'],
                ]);

               // dd($response);

                $customer->update([
                    'virtual_assistance_points' => ($customer->virtual_assistance_points ?? 0) + ($subscription->virtual_assistance_points ?? 0),
                    'call_service_points' => ($customer->call_service_points ?? 0) + ($subscription->call_service_points ?? 0),
                    'general_support_points' => ($customer->general_support_points ?? 0) + ($subscription->general_support_points ?? 0),
                ]);


                return view('user.customers.payment-success', ['data' => $response['responseBody']]);
            } else {
                return view('user.customers.payment-failed', ['data' =>  $response['responseBody']]);
            }
        } catch (\Exception $e) {
            $subscription->update(['status' => 'failed']);
            return response()->json(['error' => $e->getMessage()], 400);
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
