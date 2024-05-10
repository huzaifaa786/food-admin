<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\CartHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        $cart = CartHelper::addToCart($request);

        if($cart['message']){
            return Api::setError($cart['message']);
        }
        else{
            return Api::setResponse('cart', $cart);
        }

    }

    /**
     * Method update
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function update(Request $request)
    {
        $cart = CartHelper::updateCartItem($request);

        return Api::setResponse('cart', $cart);
    }

    public function remove(Request $request)
    {
        $cart = CartHelper::removeFromCart($request);

        return Api::setResponse('cart', $cart);
    }

    /**
     * Method get
     *
     * @return void
     */
    public function get()
    {
        $cart = CartHelper::getCart();

        return Api::setResponse('cart', $cart);
    }
}
