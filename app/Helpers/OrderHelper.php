<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class OrderHelper
{
    public static function getRestrauntOrders()
    {
        $res = auth()->user();

        $orders = DB::table('orders')
        ->select(
            'orders.id',
            'orders.user_id',
            'orders.restaurant_id',
            'orders.total_amount',
            'orders.total_quantity',
            // You may need to join with users table to get user details
            'users.name as user_name',
            'users.email as user_email',
            'users.phone as user_phone',
            // Assuming you have a created_at field for orders
            'orders.created_at'
        )
        ->where('orders.restaurant_id', $res->id)
        ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found for this restaurant'], 404);
        }

        // Fetch order items for each order
        foreach ($orders as $order) {
            $orderItems = DB::table('order_items')
            ->select(
                'order_items.id as id',
                'order_items.notes',
                'order_items.order_id',
                'order_items.menu_item_id',
                'order_items.quantity',
                'order_items.subtotal',
                'menu_items.name as name',
                'menu_items.description as description',
                'menu_items.price as price'
            )
                ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
                ->where('order_items.order_id', $order->id)
                ->get();

            $order->items = $orderItems;
        }

        return response()->json($orders, 200);
    }
}
