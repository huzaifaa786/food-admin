<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Restraunt;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function index(){
        $restaurants = Restraunt::withCount('rider')->get();
        return view('admin.riders.index')->with('restaurants', $restaurants);
    }

    public function ridersinfo($id){
        $restaurants  = Restraunt::latest()->find($id);
        $riders = $restaurants->rider;
        return view('admin.riders.detail', ['riders' => $riders]);
    }

    public function riderorder(Request $request){
        $id = $request->id;
        $driver = Driver::with('orders.useraddress')->find($id);
        $orders = $driver->orders;
        return response()->json($orders);
    }
}
