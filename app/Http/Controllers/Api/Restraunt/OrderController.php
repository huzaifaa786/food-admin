<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Enums\OrderStatus;
use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use PDO;

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
            return Api::setResponse('orders', []);
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

        $order = Order::find($order->id);

        $rider = Driver::find($request->driver_id);
        if ($rider) {
            (new NotificationService())->sendNotification(
                sendTo: 'RIDER',
                receiverId: $rider->id,
                deviceToken: $rider->fcm_token ?? '',
                orderId: $order->id,
                orderStatus: $order->status,
                title: 'Order Assigned',
                body: 'New order assigned',
                ar_body: 'طلب جديد'
            );
        }

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

        $user = User::find($order->user_id);
        if ($user) {
            (new NotificationService())->sendNotification(
                sendTo: 'USER',
                receiverId: $user->id,
                deviceToken: $user->fcm_token ?? '',
                orderId: $order->id,
                orderStatus: $order->status,
                title: 'Order Accepted',
                body: 'Your order has been accepted',
                ar_body: 'تم قبول طلبك'
            );
        }

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
        $user = User::find($order->user_id);
        if ($user) {
            (new NotificationService())->sendNotification(
                sendTo: 'USER',
                receiverId: $user->id,
                deviceToken: $user->fcm_token ?? '',
                orderId: $order->id,
                orderStatus: $order->status,
                title: 'Order Rejected',
                body: 'Your order has been rejected',
                ar_body: 'تم رفض طلبك'
            );
        }

        return Api::setMessage('Order Rejected');
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
