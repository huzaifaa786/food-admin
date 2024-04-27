<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restraunt;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurant = Restraunt::all();
        return view('admin.restraunts.index')->with('restaurants', $restaurant);
    }

    public function resturantorder($id)
    {
        $restraunt = Restraunt::latest()->find($id);
        $orders = $restraunt->resturantorders;
        return view('admin.restraunts.restraunts_order', ['orders' => $orders]);
    }

    public function orderitems(Request $request)
    {
        $id = $request->id;
        $order = Order::with('items.menu_item')->find($id);
        $orderitems = $order->items;
        return response()->json($orderitems);
    }
    
}
