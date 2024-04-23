<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    public $serverKey;

    public function __construct()
    {
        $this->serverKey = env('FIREBASE_SERVER_KEY');
    }

    function sendNotification($sendTo, $receiverId, $deviceToken, $title, $body)
    {
        $notificationData = [
            'title' => $title,
            'body' => $body,
        ];

        switch ($sendTo) {
            case 'USER':
                $notificationData['user_id'] = $receiverId;
                break;
            case 'RIDER':
                $notificationData['driver_id'] = $receiverId;
                break;
            case 'RES':
                $notificationData['restraunt_id'] = $receiverId;
                break;
            default:
                break;
        }

        Notification::create($notificationData);
        
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
