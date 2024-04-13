<?php

namespace App\Http\Controllers\Api\Rider;

use App\Enums\OrderStatus;
use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderHelper::getRiderOrders();
       return Api::setResponse('orders', $orders);
    }

    /**
     * Method deliverOrder
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function deliverOrder($id)
    {
        $order = Order::find($id);
        $order->update(['status' => OrderStatus::DELIVERED->value]);
        return Api::setMessage('Order Delivered');
    }
}
