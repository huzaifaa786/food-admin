<?php

namespace App\Helpers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CartHelper
{
    public static function addToCart(CartRequest $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => auth()->user()->id,
                'restraunt_id' => $request->restraunt_id

            ]);
        }

        $cartItem = CartItem::updateOrCreate([
            'cart_id' => $cart->id,
            'menu_item_id' => $request->menu_item['id'],
        ], [
            'quantity' => $request->menu_item['quantity'],
            'notes' => $request->menu_item['notes'] ?? null
        ]);


        foreach ($request->menu_item['extras'] as $extra) {
            CartItemExtra::firstOrCreate([
                'cart_item_id' => $cartItem->id,
                'extra_id' => $extra['id']
            ]);
        }
        $cartItem->calculateSubtotal();


        $cart->calculateTotals();

        // Fetch the cart with the user ID and its associated items
        $userCart = Cart::with('items')->where('user_id', auth()->user()->id)->first();

        return $userCart;
    }

    public static function updateCartItem(Request $request)
    {
        $cartItem = CartItem::whereHas('cart', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->where('id', $request->cart_item_id)->first();

        if (!$cartItem) {
            return ['message' => 'Item not found in the cart'];
        }


        $cartItem->quantity = $request->quantity;
        $cartItem->calculateSubtotal();

        $cartItem->cart->calculateTotals();
        $userCart = self::getCart();

        return $userCart ? $userCart : ['message' => 'Cart item not updated'];
    }

    public static function removeFromCart(Request $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();

        if (!$cart) {
            return null;
        }

        $cartItem = $cart->items()->where('id', $request->cart_item_id)->first();

        if ($cartItem) {
            $cartItem->delete();
            $cart->calculateTotals();

        } else {
            return response()->json(['message' => 'Item not found in the cart'], 404);
        }

        $userCart = self::getCart();
        return $userCart;
    }

    public static function clearCart()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();

        if (!$cart) {
            return null;
        }
        // $cart->items()->delete();
        $cart->delete();

        return ['message' => 'Cart cleared successfully'];
    }

    public static function getCart()
    {
        $userId = auth()->user()->id;

        $cart = DB::table('carts')
            ->select(
                'carts.id',
                'carts.user_id',
                'carts.restraunt_id',
                'carts.total_amount',
                'carts.total_quantity',
                'restraunts.name as restaurant_name',
                DB::raw("CONCAT('" . asset('') . "', restraunts.cover) as restaurant_image")
            )
                ->join('restraunts', 'carts.restraunt_id', '=', 'restraunts.id')
                ->where('carts.user_id', $userId)
                ->first();


        if (!$cart) {

            return null;
        }

        $items =  DB::table('cart_items')
            ->select(
                'cart_items.id as id',
                'cart_items.notes',
                'cart_items.cart_id',
                'cart_items.menu_item_id',
                'cart_items.quantity',
                'cart_items.subtotal',
                'menu_items.name as name',
                'menu_items.description as description',
                DB::raw("CONCAT('" . asset('') . "', menu_items.image) as image"),
                'menu_items.price as price'
            )
                ->leftJoin('menu_items', 'cart_items.menu_item_id', '=', 'menu_items.id')
                ->leftJoin('cart_item_extras', 'cart_items.id', '=', 'cart_item_extras.cart_item_id')
                ->where('cart_items.cart_id', $cart->id)
                ->get();


        $itemIds = $items->pluck('id')->toArray();
        $extras = DB::table('cart_item_extras')
        ->select(
            'cart_item_id',
            'extras.id as id',
            'extras.name as name',
            'extras.price as price',
            'extras.menu_item_id as menu_item_id'
        )
            ->join('extras', 'cart_item_extras.extra_id', '=', 'extras.id')
            ->whereIn('cart_item_id', $itemIds)
            ->get()
            ->groupBy('cart_item_id');

        foreach ($items as $item) {
            $item->extras = $extras[$item->id] ?? [];
        }

        $cart->items = $items;

        return $cart;
    }
}
