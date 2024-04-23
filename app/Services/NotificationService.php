<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService
{
    public $serverKey;

    public function __construct()
    {
        $this->serverKey = env('FIREBASE_SERVER_KEY');
    }

    function sendNotification($deviceToken, $title, $body)
    {
        $serverKey = 'YOUR_SERVER_KEY'; // Replace with your Firebase server key

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'to' => $deviceToken,
        ]);

        return $response->json();
    }
}
