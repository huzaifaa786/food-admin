<?php

namespace App\Http\Controllers\Api\Rider;

use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderHelper::getRiderOrders();
       return Api::setResponse('orders', $orders);
    }
}
