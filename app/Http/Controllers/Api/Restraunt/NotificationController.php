<?php

namespace App\Http\Controllers\Api\Restraunt;

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
        dd('sdf');
        $notifications = Notification::where('restraunt_id', auth()->user()->id)->get();
        return Api::setResponse('notifications', $notifications);
    }
}
