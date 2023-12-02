<?php

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Notification;
use GuzzleHttp\Client;

function gs()
{
    return (object) Setting::all()->pluck("value", "key")->toArray();
}

//Active Currency
function ac()
{
    return "₦";
}

function getTrx($length = 4)
{

    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $currentDateTime = now()->format("YmdHi");

    return $currentDateTime . $randomString;
}

function discount_amount($value, $amount, $discountType = 'fixed')
{
    if ($discountType == 'fixed') {
        return $value;
    }

    return round(($value / 100) * $amount, 2);
}

function upload_file($file, $filePath, $previousPath = null, $isupdating = false)
{
    if (!$file && $isupdating) return $previousPath; // return previous path if we updating file and file upload exists

    if (file_exists($previousPath)) unlink($previousPath);

    if (!$file) return null;

    return 'storage/' . $file->storeAs($filePath, Str::uuid() . '.' . $file->extension());
}

function save_transaction($data)
{
    return Transaction::create([
        'user_id' => $data['user_id'],
        'amount' => $data['amount'],
        'trx' => $data['trx'],
        'discount_amount' => $data['discount_amount'] ?? 0,
        'charge' => $data['charge'],
        'trx_type' => $data['type'],
        'details' => $data['details'],
        'remark' => $data['remark'],
        'query1' => $data['query1'] ?? []
    ]);
}

function get_transaction($id)
{
    return Transaction::findOrFail($id);
}

function save_notification($data)
{
    return Notification::create([
        'user_id' => $data['user_id'],
        'title' => $data['title'],
        'content' => $data['content'],
    ]);
}

function deduct_from_wallet($amount)
{
    return auth()->user()->decrement('wallet_balance', $amount);
}

function send_push_notification($data, $fcmToken = null)
{
    // Your FCM server key obtained from Firebase Console
    $serverKey = gs()->server_key;


    $title = $data['title'] ?? null;
    $body = $data['content'] ?? null;
    $image = isset($data['image']) ? asset($data['image']) : asset(gs()->logo);
    $fcmToken = is_null($fcmToken) ? "/topics/all-users" : $fcmToken;

    // Construct the notification payload
    $notification = [
        'title' => $title,
        'body' => $body,
        'image' => $image,
    ];

    // Create a Guzzle HTTP client
    $client = new Client();

    // FCM endpoint
    $url = 'https://fcm.googleapis.com/fcm/send';

    // Construct the request payload
    $payload = [
        'to' => $fcmToken, // Send to a specific topic (all users)
        'notification' => $notification,
    ];

    // Set headers, including authorization
    $headers = [
        'Authorization' => 'key=' . $serverKey,
        'Content-Type' => 'application/json',
    ];

    try {
        // Send the POST request to FCM
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $payload,
        ]);

        // Handle the response (e.g., log or return success)
        $responseBody = json_decode($response->getBody(), true);

        return response()->json(['message' => 'Push notification sent', 'response' => $responseBody]);
    } catch (\Exception $e) {
        // Handle any errors that occur during the request
        return response()->json(['error' => 'Failed to send push notification', 'message' => $e->getMessage()], 500);
    }
}


function sanitize_image_array($images)
{
    $prefixToRemove = env("APP_URL") . "/";

    return array_map(function ($url) use ($prefixToRemove) {
        return str_replace($prefixToRemove, "", $url);
    }, $images);
}

function sanitize_image_path($unsanitizeImagePath)
{
    $prefixToRemove = env("APP_URL") . "/";

    return str_replace($prefixToRemove, '', $unsanitizeImagePath);
}


function ordinal($number)
{
    if ($number % 100 >= 11 && $number % 100 <= 13) {
        $suffix = 'th';
    } else {
        switch ($number % 10) {
            case 1:
                $suffix = 'st';
                break;
            case 2:
                $suffix = 'nd';
                break;
            case 3:
                $suffix = 'rd';
                break;
            default:
                $suffix = 'th';
                break;
        }
    }

    return $number . $suffix;
}
