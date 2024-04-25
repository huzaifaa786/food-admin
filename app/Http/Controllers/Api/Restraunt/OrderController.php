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
            return Api::setError('No orders found');
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

        $rider = Driver::find($request->driver_id);
        if ($rider) {
            (new NotificationService())->sendNotification(
                sendTo: 'RIDER',
                receiverId: $rider->id,
                deviceToken: $rider->fcm_token ?? '',
                orderId: $order->id,
                orderStatus: $order->status,
                title: 'Order Assigned',
                body: 'a new order has been assigned'
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
                sendTo: 'RES',
                receiverId: $user->id,
                deviceToken: $user->fcm_token ?? '',
                orderId: $order->id,
                orderStatus: $order->status,
                title: 'Order Accepted',
                body: 'your order has been accepted'
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
                sendTo: 'RES',
                receiverId: $user->id,
                deviceToken: $user->fcm_token ?? '',
                orderId: $order->id,
                orderStatus: $order->status,
                title: 'Order Rejected',
                body: 'your order has been rejected'
            );
        }

        return Api::setMessage('Order Rejected');
    }
}
