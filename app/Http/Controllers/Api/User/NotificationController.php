<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Api::setResponse('notifications', $notifications);
    }
}
