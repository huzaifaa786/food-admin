<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\LocationHelper;
use App\Helpers\OrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemExtra;
use App\Models\RestaurantFee;
use App\Models\Restraunt;
use App\Models\UserAddress;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart = Cart::find($request->cart_id);

        if ($cart) {
            $restaurant = Restraunt::find($cart->restraunt_id);
            $fee = RestaurantFee::first();
            $total = $cart->total_amount + $fee->service_charges + $restaurant->delivery_charges;
            $order = Order::create([
                'total_amount' => $total,
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
                        'quantity' => $extra->quantity,
                    ]);
                }
            }
            $cart->delete();

            $restraunt = Restraunt::find($cart->restraunt_id);

            $order = Order::find($order->id);

            (new NotificationService())->sendNotification(
                sendTo: 'USER',
                receiverId: auth()->user()->id,
                deviceToken: auth()->user()->fcm_token ?? '',
                orderId: $order->id,
                orderStatus: $order->status,
                title: 'order Placed',
                body: 'Your order was placed successfully',
                ar_body: 'تم وضع طلبك بنجاح'
            );

            if ($restraunt) {
                (new NotificationService())->sendNotification(
                    sendTo: 'RES',
                    receiverId: $restraunt->id,
                    deviceToken: $restraunt->fcm_token ?? '',
                    orderId: $order->id,
                    orderStatus: $order->status,
                    title: 'Order Received',
                    body: 'You received a new order',
                    ar_body: 'لقد إستلمت طلب جديد'
                );
            }

            return Api::setResponse('order', $order);
        } else {
            return Api::setError('cart not found');
        }
    }

    public function checkRange(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'restaurant_id' => 'required|exists:restraunts,id',
        ]);

        $address = UserAddress::findOrFail($request->address_id);
        $restaurant = Restraunt::findOrFail($request->restaurant_id);

        $distance = LocationHelper::calculateDistance($address->lat, $address->lng, $restaurant->lat, $restaurant->lng);

        $withinRange = $distance <= ($restaurant->radius * 1000);

        if ($withinRange) {
            return Api::setMessage('within range');
        } else {
            return Api::setError('restaurant out of range');
        }
    }

    public function index()
    {
        $orders = OrderHelper::getUserOrders();
        if ($orders != null)
            return Api::setResponse('orders', $orders);
        else
            return Api::setResponse('orders', []);
    }

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
