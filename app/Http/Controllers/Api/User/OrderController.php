<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemExtra;
use App\Models\Restraunt;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart  = Cart::find($request->cart_id);
        if ($cart) {
            $order = Order::create([
                'total_amount' => $cart->total_amount,
                'total_quantity' => $cart->total_quantity,
                'user_id' => auth()->user()->id,
                'restraunt_id' => $cart->restraunt_id,
                'user_address_id' => $request->user_address_id,
                'payment_intent' => $request->payment_intent,
            ]);

            foreach ($cart->items as $item) {
                $order_item = OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item->menu_item_id,
                    'notes' => $item->notes,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);
                foreach ($item->extras as $extra) {
                    OrderItemExtra::create([
                        'order_item_id' => $order_item->id,
                        'extra_id' => $extra->extra_id,
                    ]);
                }
            }
            $cart->delete();

            $restraunt = Restraunt::find($cart->restraunt_id);

            (new NotificationService())->sendNotification(
                sendTo: 'USER',
                receiverId: auth()->user()->id,
                deviceToken: auth()->user()->fcm_token ?? '',
                title: 'order placed',
                body: 'boht boht mubarak ho hehe'
            );

            if ($restraunt) {
                (new NotificationService())->sendNotification(
                    sendTo: 'RES',
                    receiverId: $restraunt->id,
                    deviceToken: $restraunt->fcm_token ?? '',
                    title: 'order placed',
                    body: 'res order placed'
                );
            }

            return Api::setResponse('order', $order);
        } else {
            return Api::setError('cart not found');
        }
    }

    public function index()
    {
        $orders = OrderHelper::getUserOrders();
        if ($orders != null)
            return Api::setResponse('orders', $orders);
        else
            return Api::setError('No orders found');
    }
}
