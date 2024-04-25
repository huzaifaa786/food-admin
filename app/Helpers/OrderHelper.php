<?php

namespace App\Helpers;

use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;

class OrderHelper
{
    public static function getRestrauntOrders()
    {
        $res = auth()->user();
        $orders = [];

        foreach (OrderStatus::cases() as $status) {
            $statusOrders = DB::table('orders')
                ->select(
                    'orders.id',
                    'orders.user_id',
                    'orders.restraunt_id',
                    'orders.total_amount',
                    'orders.total_quantity',
                    'orders.status',
                    'restraunts.name as restraunt_name',
                    'user_addresses.lat as user_lat',
                    'user_addresses.lng as user_lng',
                    // You may need to join with users table to get user details
                    'users.name as user_name',
                    'users.email as user_email',
                    'users.phone as user_phone',
                    DB::raw("CONCAT('" . asset('') . "', users.image) as user_image"),
                    'orders.created_at'
                )
                ->join('restraunts', 'orders.user_id', '=', 'restraunts.id')
                ->join('user_addresses', 'orders.user_address_id', '=', 'user_addresses.id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('orders.restraunt_id', $res->id)
                ->where('orders.status', $status->value)
                ->orderBy('orders.created_at', 'desc')
                ->get();
            if (!$statusOrders->isEmpty()) {

                foreach ($statusOrders as $order) {
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
                            'menu_items.price as price',
                            DB::raw("CONCAT('" . asset('') . "', menu_items.image) as image"),
                        )
                        ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
                        ->where('order_items.order_id', $order->id)
                        ->get();

                    $itemIds = $orderItems->pluck('id')->toArray();
                    $extras = DB::table('order_item_extras')
                        ->select(
                            'order_item_id',
                            'extras.id as id',
                            'extras.name as name',
                            'extras.price as price',
                            'extras.menu_item_id as menu_item_id'
                        )
                        ->join('extras', 'order_item_extras.extra_id', '=', 'extras.id')
                        ->whereIn('order_item_id', $itemIds)
                        ->get()
                        ->groupBy('order_item_id');

                    foreach ($orderItems as $item) {
                        $item->extras = $extras[$item->id] ?? [];
                    }

                    $order->items = $orderItems;
                }
            }
            // dump($statusOrders);

            $orders[$status->value] = $statusOrders->toArray();
        }

        return $orders;
    }

    public static function getUserOrders()
    {
        $user = auth()->user();

        $orders = DB::table('orders')
            ->select(
                'orders.id',
                'orders.user_id',
                'orders.restraunt_id',
                'orders.total_amount',
                'orders.total_quantity',
                'orders.status',
                'restraunts.name as restraunt_name',
                'restraunts.lat as restraunt_lat',
                'restraunts.lng as restraunt_lng',
                'user_addresses.lat as user_lat',
                'user_addresses.lng as user_lng',
                // You may need to join with users table to get user details
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                'users.image as user_image',
                'orders.created_at'
            )
            ->join('restraunts', 'orders.user_id', '=', 'restraunts.id')
            ->join('user_addresses', 'orders.user_address_id', '=', 'user_addresses.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.user_id', $user->id)
            ->orderBy('orders.created_at', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return null;
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
                    'menu_items.price as price',
                    DB::raw("CONCAT('" . asset('') . "', menu_items.image) as image"),
                )
                ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
                ->where('order_items.order_id', $order->id)
                ->get();

            $itemIds = $orderItems->pluck('id')->toArray();
            $extras = DB::table('order_item_extras')
                ->select(
                    'order_item_id',
                    'extras.id as id',
                    'extras.name as name',
                    'extras.price as price',
                    'extras.menu_item_id as menu_item_id'
                )
                ->join('extras', 'order_item_extras.extra_id', '=', 'extras.id')
                ->whereIn('order_item_id', $itemIds)
                ->get()
                ->groupBy('order_item_id');

            foreach ($orderItems as $item) {
                $item->extras = $extras[$item->id] ?? [];
            }

            $order->items = $orderItems;
        }

        return $orders;
    }

    public static function getOrderById($orderId)
    {
        $user = auth()->user();

        $order = DB::table('orders')
            ->select(
                'orders.id',
                'orders.user_id',
                'orders.restraunt_id',
                'orders.total_amount',
                'orders.total_quantity',
                'orders.status',
                'restraunts.name as restraunt_name',
                'restraunts.lat as restraunt_lat',
                'restraunts.lng as restraunt_lng',
                'user_addresses.lat as user_lat',
                'user_addresses.lng as user_lng',
                // You may need to join with users table to get user details
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                'users.image as user_image',
                'orders.created_at'
            )
            ->join('restraunts', 'orders.user_id', '=', 'restraunts.id')
            ->join('user_addresses', 'orders.user_address_id', '=', 'user_addresses.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.id', $orderId)
            ->first();

        if ($order == null) {
            return null;
        }

        // Fetch order items for the order
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
                'menu_items.price as price',
                DB::raw("CONCAT('" . asset('') . "', menu_items.image) as image"),
            )
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->where('order_items.order_id', $orderId)
            ->get();

        $itemIds = $orderItems->pluck('id')->toArray();
        $extras = DB::table('order_item_extras')
            ->select(
                'order_item_id',
                'extras.id as id',
                'extras.name as name',
                'extras.price as price',
                'extras.menu_item_id as menu_item_id'
            )
            ->join('extras', 'order_item_extras.extra_id', '=', 'extras.id')
            ->whereIn('order_item_id', $itemIds)
            ->get()
            ->groupBy('order_item_id');

        foreach ($orderItems as $item) {
            $item->extras = $extras[$item->id] ?? [];
        }

        $order->items = $orderItems;

        return $order;
    }



    public static function getRiderOrders()
    {
        $rider = auth()->user();
        $orders = [];

        foreach (OrderStatus::cases() as $status) {
            $statusOrders = DB::table('orders')
            ->select(
                'orders.id',
                'orders.user_id',
                'orders.restraunt_id',
                'orders.total_amount',
                'orders.total_quantity',
                'orders.status',
                'restraunts.name as restraunt_name',
                'restraunts.lat as restraunt_lat',
                'restraunts.lng as restraunt_lng',
                'user_addresses.lat as user_lat',
                'user_addresses.lng as user_lng',
                'user_addresses.address as address',
                // You may need to join with users table to get user details
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                'users.image as user_image',
                'orders.created_at'
            )
                ->join('restraunts', 'orders.user_id', '=', 'restraunts.id')
                ->join('user_addresses', 'orders.user_address_id', '=', 'user_addresses.id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('orders.driver_id', $rider->id)
                ->where('orders.status', $status->value)
                ->orderBy('orders.created_at', 'desc')
                ->get();

            if (!$statusOrders->isEmpty()) {
                // Fetch order items for each order
                foreach ($statusOrders as $order) {
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
                        'menu_items.price as price',
                        DB::raw("CONCAT('" . asset('') . "', menu_items.image) as image"),
                    )
                        ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
                        ->where('order_items.order_id', $order->id)
                        ->get();

                    $itemIds = $orderItems->pluck('id')->toArray();
                    $extras = DB::table('order_item_extras')
                    ->select(
                        'order_item_id',
                        'extras.id as id',
                        'extras.name as name',
                        'extras.price as price',
                        'extras.menu_item_id as menu_item_id'
                    )
                        ->join('extras', 'order_item_extras.extra_id', '=', 'extras.id')
                        ->whereIn('order_item_id', $itemIds)
                        ->get()
                        ->groupBy('order_item_id');

                    foreach ($orderItems as $item) {
                        $item->extras = $extras[$item->id] ?? [];
                    }

                    $order->items = $orderItems;
                }
            }

            $orders[$status->value] = $statusOrders->toArray();
        }

        return $orders;
    }
}
