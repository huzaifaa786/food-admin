<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuItem;
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
    public function resturantStatus($id)
    {
        $restraunt = Restraunt::find($id);
        $restraunt->update([
            'is_approved' => !$restraunt->is_approved,
        ]);
        return redirect()->back();
    }

    public function orderitems(Request $request)
    {
        $id = $request->id;
        $order = Order::with('items.menu_item')->find($id);
        $orderitems = $order->items;
        return response()->json($orderitems);
    }
    public function showMenu()
    {
        $menuCategories = MenuCategory::with('restraunt')->get();

        return view('admin.menus.index', compact('menuCategories'));
    }
    public function showMenuItems($restaurantId)
    {
        $menuItems = MenuItem::where('restraunt_id', $restaurantId)
            ->get();

        return view('admin.menus.menu_items', compact('menuItems'));
    }

    public function allOrders()
    {
        $orders = Order::all();
        return view('admin.order.index', ['orders' => $orders]);
    }
}
