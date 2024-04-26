<?php

namespace App\Http\Controllers\Api\Rider;

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
        $notifications = Notification::where('driver_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return Api::setResponse('notifications', $notifications);
    }

    /**
     * Method unreadCount
     *
     * @return void
     */
    public function unreadCount()
    {
        $count = Notification::where('driver_id', auth()->user()->id)->where('seen', false)->count();
        return Api::setResponse('count', $count);
    }

    /**
     * Method seenNotification
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function seenNotification($id)
    {
        $notification = Notification::find($id);
        $notification->update(['seen' => true]);
        return Api::setMessage('success');
    }
}
