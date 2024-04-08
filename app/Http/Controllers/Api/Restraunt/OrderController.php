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
        if ($orders != null)
            return Api::setResponse('orders', $orders);
        else
            return Api::setMessage('No orders found');
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

    /**
     * Method acceptOrder
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function acceptOrder($id)
    {
        $order = Order::find($id);
        $order->update(['status' => OrderStatus::ACCEPTED->value]);
        return Api::setMessage('Order Accepted');
    }

    /**
     * Method rejectOrder
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function rejectOrder($id)
    {
        $order = Order::find($id);
        $order->update(['status' => OrderStatus::REJECTED->value]);
        return Api::setMessage('Order Rejected');
    }
}
