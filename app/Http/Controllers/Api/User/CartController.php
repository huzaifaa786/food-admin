<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemExtra;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Method add
     *
     * @param CartRequest $request [explicite description]
     *
     * @return void
     */
    public function add(CartRequest $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id);
        if($cart){
            $cartItem = CartItem::updateOrCreate([
                'cart_id' => $cart->id,
                'menu_item_id' => $request->menu_item_id,
            ],[
                'notes' => $request->notes
            ]);

            foreach($request->extras as $extra){
                CartItemExtra::create([
                    'cart_item_id' => $cartItem->id,
                     'extra_id' => $extra->id
                ]);
            }
        }
         $cart = Cart::create([
            'user_id' => auth()->user->id,
            'restraunt_id' => $request->restaurant_id
         ]);

         return Api::setResponse('cart', $cart);
    }
}
