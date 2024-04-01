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

        return Api::setResponse('cart', $cart);
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

    /**
     * Method get
     *
     * @return void
     */
    public function get()
    {
        $userId = auth()->user()->id;

        // Attempt to retrieve the cart from the cache
        $cart = Cache::remember('user_cart_' . $userId, now()->addMinutes(10), function () use ($userId) {
            return DB::table('carts')
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
        });

        if (!$cart) {
            // Handle case when cart is not found
            return response()->json(['error' => 'Cart not found'], 404);
        }

        // Attempt to retrieve the items from the cache
        $items = Cache::remember('cart_items_' . $cart->id, now()->addMinutes(10), function () use ($cart) {
            return DB::table('cart_items')
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
        });

        // Eager loading for extras
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

        return Api::setResponse('cart', $cart);
    }
}
