<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function index()
   {
        $orders = OrderHelper::getRestrauntOrders();
        return Api::setResponse('orders', $orders);
   }
}
