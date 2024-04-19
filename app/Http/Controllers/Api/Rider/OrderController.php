<?php

namespace App\Http\Controllers\Api\Rider;

use App\Enums\OrderStatus;
use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLocation;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderHelper::getRiderOrders();
        if ($orders != null)
            return Api::setResponse('orders', $orders);
        else
            return Api::setError('No orders found');
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

    /**
     * Method changeOrderLocation
     *
     * @param Request $request to change order location
     *
     * @return void
     */
    public function changeOrderLocation(Request $request)
    {
        $orderlocation = OrderLocation::where('order_id', $request->order_id)->first();
        if ($orderlocation) {
        dd(
            $orderlocation);

            $orderlocation->update([
                'lat' => $request->lat,
                'lng' => $request->lng,
            ]);
        } else {
            OrderLocation::create([
                'order_id' => $request->order_id,
                'lat' => $request->lat,
                'lng' => $request->lng
            ]);
        }

        return Api::setMessage('Location updated');
    }
}
