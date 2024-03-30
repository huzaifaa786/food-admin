<?php

namespace App\Helpers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemExtra;
use Illuminate\Http\Request;

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
            'quantity' => $request->menu_item['quantity'],
            'menu_item_id' => $request->menu_item['id'],
        ], [
            'notes' => $request->menu_item['notes'] ?? null
        ]);


        foreach ($request->menu_item['extras'] as $extra) {
            CartItemExtra::create([
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
        })->where('menu_item_id', $request->menu_item_id)->first();

        if (!$cartItem) {
            return ['message' => 'Item not found in the cart'];
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->calculateSubtotal();
        $cartItem->save();

        $cartItem->cart->calculateTotals();
        $userCart = Cart::with('items')->where('user_id', auth()->user()->id)->first();

        return $userCart ? $userCart : ['message' => 'Cart item not updated'];
    }

    public static function removeFromCart(CartRequest $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();

        if (!$cart) {
            return null;
        }

        $cartItem = $cart->items()->where('menu_item_id', $request->menu_item_id)->first();

        if ($cartItem) {
            $cartItem->delete();
            $cart->calculateTotals();
        } else {
            return response()->json(['message' => 'Item not found in the cart'], 404);
        }
        $userCart = Cart::with('items')->where('user_id', auth()->user()->id)->first();
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
}
