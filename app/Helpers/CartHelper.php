<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\CartItems;

class CartHelper
{
    public static function addToCart($userId, $gamecode_id, $quantity)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
            ]);
        }

        if ($gamecode_id) {
            $existingCartItem = $cart->items()->where('gamecode_id', $gamecode_id)->first();

            if ($existingCartItem) {
                $existingCartItem->quantity += $quantity ?? 1;
                $existingCartItem->calculateSubtotal();
            } else {
                $cartItem = CartItems::create([
                    'cart_id' => $cart->id,
                    'gamecode_id' => $gamecode_id,
                    'quantity' => $quantity ?? 1,
                ]);
                $cartItem->calculateSubtotal();
            }
        }

        $cart->calculateTotals();

        // Fetch the cart with the user ID and its associated items
        $userCart = Cart::with('items')->with('items.gamecode')->with('items.gamecode.game')->where('user_id', $userId)->first();

        return $userCart;
    }
    public static function updateCartItem($gamecode_id, $user_id, $quantity)
    {
        $cartItem = CartItems::whereHas('cart', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->where('gamecode_id', $gamecode_id)->first();

        if (!$cartItem) {
            return ['message' => 'Item not found in the cart'];
        }

        $cartItem->quantity = $quantity;
        $cartItem->calculateSubtotal();
        $cartItem->save();

        $cartItem->cart->calculateTotals();
        $userCart = Cart::with('items')->with('items.gamecode')->with('items.gamecode.game')->where('user_id', $user_id)->first();

        return $userCart ? $userCart : ['message' => 'Cart item not updated'];
    }

    public static function removeFromCart($userId, $gamecode_id)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return null;
        }

        $cartItem = $cart->items()->where('gamecode_id', $gamecode_id)->first();

        if ($cartItem) {
            $cartItem->delete();
            $cart->calculateTotals();
        } else {
            return response()->json(['message' => 'Item not found in the cart'], 404);
        }
        $userCart = Cart::with('items')->with('items.gamecode')->with('items.gamecode.game')->where('user_id', $userId)->first();
        return $userCart;
    }

    public static function clearCart($user_id)
    {
        $cart = Cart::where('user_id', $user_id)->first();
    
        if (!$cart) {
            return null;
        }
        // $cart->items()->delete();
        $cart->delete();
    
        return ['message' => 'Cart cleared successfully'];
    }
}
