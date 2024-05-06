<?php

namespace App\Http\Controllers\Api\Rider;

use App\Enums\OrderStatus;
use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLocation;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderHelper::getRiderOrders();
        if ($orders != null)
            return Api::setResponse('orders', $orders);
        else
            return Api::setResponse('orders', []);
    }

    public function onWayOrder($id)
    {
        $order = Order::find($id);
        $user = $order->user;
        $order->update(['status' => OrderStatus::ON_THE_WAY->value]);

        (new NotificationService())->sendNotification(
            sendTo: 'USER',
            receiverId: $user->id,
            deviceToken: $user->fcm_token ?? '',
            orderId: $order->id,
            orderStatus: $order->status,
            title: 'Order on way',
            body: 'Your order is now on the way',
            ar_body: 'طلبك في طريقه إليك'
        );
        return Api::setMessage('Order marked as on the way');
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
        $user = $order->user;
        $order->update(['status' => OrderStatus::DELIVERED->value]);

        (new NotificationService())->sendNotification(
            sendTo: 'USER',
            receiverId: $user->id,
            deviceToken: $user->fcm_token ?? '',
            orderId: $order->id,
            orderStatus: $order->status,
            title: 'Order Delivered',
            body: 'Your order was delivered',
            ar_body: 'تم توصيل طلبك'
        );

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

    /**
     * Method getOrder
     *
     * @param $orderId $orderId [explicite description]
     *
     * @return void
     */
    public function getOrder($orderId)
    {
        $order = OrderHelper::getOrderById($orderId);

        if ($order != null) {
            return Api::setResponse('order', $order);
        } else {
            return Api::setError('Order not found');
        }
    }
}
