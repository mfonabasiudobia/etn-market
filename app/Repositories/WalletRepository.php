<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use App\Models\User;
use App\Models\UserVirtualBank;
use Illuminate\Support\Facades\Http;

class WalletRepository
{

    public static function generateBrearerToken()
    {
        $apiKey = 'MK_TEST_X780UWL1CM';
        $clientSecret = 'PRFK8JR6PC0VA6NKEDYF8V93JZCTYNA4';

        $credentials = "$apiKey:$clientSecret";
        $base64Credentials = base64_encode($credentials);

        $apiEndpointUrl = env('MONIFY_BASE_URL') . "/api/v1/auth/login";

        $response = Http::withHeaders([
            'Authorization' => "Basic $base64Credentials"
        ])->post($apiEndpointUrl);

        return $response->json();
    }

    public static function generateVirtualAccount($user, $bankCode)
    {

        try {
            $client = new Client();

            $headers = [
                'Authorization' => 'Bearer ' . self::generateBrearerToken()['responseBody']['accessToken'],
                'Content-Type' =>  'application/json'
            ];

            $requestData = [
                "accountReference" => getTrx(),
                "accountName" => $user->fullname,
                "currencyCode" => "NGN",
                "contractCode" => "8749518740", //get from settings
                "customerEmail" => $user->email,
                "customerName" => $user->fullname,
                "bvn" => "22491599296", //get from settings
                "getAllAvailableBanks" => true,
                // "preferredBanks" => $bankCode
            ];

            $apiEndpointUrl = env('MONIFY_BASE_URL') . "/api/v2/bank-transfer/reserved-accounts";

            $response = $client->post($apiEndpointUrl, [
                'headers' => $headers,
                'json' => $requestData,
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            $account = $responseBody['responseBody']['accounts'][0]; //single account


            UserVirtualBank::create([
                'bank_name' => $account['bankName'],
                'bank_code' => $account['bankCode'],
                'account_name' => $account['accountName'],
                'account_number' => $account['accountNumber'],
                'user_id' => $user->id
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public static function topUp(string $userId, int $amount): User
    {
        $user = User::findOrFail($userId);

        $user->increment('wallet_balance', $amount);

        return $user->refresh();
    }

    public static function charge(string $userId, $amount): User
    {

        $user = User::findOrFail($userId);

        $user->decrement('wallet_balance', $amount);

        return $user->refresh();
    }

    public static function canPurchase(string $userId, int $amount)
    {
        $user = User::findOrFail($userId);

        return ($user->wallet_balance >= $amount);
    }
}
