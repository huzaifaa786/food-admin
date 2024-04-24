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

        $serverKey = 'AAAAmUB5VME:APA91bEEsiaGAd-6RrvZ5_0l4vK_QmGMFHzs2_Vz5WWKhxshgTVuq3Snm3hubHsPeZnB4_fpZiELo6V1efkg3MKLkEmUDdhoe0R3-KhHfqEhgbax10602ziG3BxpKPe3jw5Ne5DB4gEz'; // Replace with your Firebase server key

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
