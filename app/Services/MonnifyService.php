<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MonnifyService
{
    protected $baseUrl;
    protected $apiKey;
    protected $secretKey;
    protected $contractCode;

    public function __construct()
    {
        $this->baseUrl = config('services.monnify.base_url');
        $this->apiKey = config('services.monnify.api_key');
        $this->secretKey = config('services.monnify.secret_key');
        $this->contractCode = config('services.monnify.contract_code');
    }

    public function getAccessToken()
    {
        return Cache::remember('monnify_token', 3600, function () {
            $response = Http::withBasicAuth($this->apiKey, $this->secretKey)
                ->post("{$this->baseUrl}/api/v1/auth/login");

            return $response->json('responseBody.accessToken');
        });
    }

    public function initializeTransaction(array $data)
    {
        $token = $this->getAccessToken();
        //dd($this->baseUrl);
       // dd($data);

        return Http::withToken($token)->post("{$this->baseUrl}/api/v1/merchant/transactions/init-transaction", [
            "amount" => $data['amount'],
            "customerName" => $data['name'],
            "customerEmail" => $data['email'],
            "paymentReference" => $data['reference'],
            // "paymentDescription" => $data['description'],
            "currencyCode" => "NGN",
            "contractCode" => $this->contractCode,
            "redirectUrl" => $data['redirect_url']
        ])->json();
    }

    
    public function verifyTransaction($transactionReference)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/api/v2/transactions/{$transactionReference}");

        return $response->json();
    }
}
