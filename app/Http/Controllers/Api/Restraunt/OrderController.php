<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Enums\OrderStatus;
use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $orders = OrderHelper::getRestrauntOrders();
        return Api::setResponse('orders', $orders);
    }

    /**
     * Method assignDriver
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function assignDriver(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->update([
            'driver_id' => $request->driver_id,
            'status' => OrderStatus::ON_THE_WAY->value
        ]);
        return Api::setMessage('Driver Assigned');
    }
}
