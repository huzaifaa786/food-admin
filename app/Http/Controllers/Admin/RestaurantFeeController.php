<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantFee;

use Illuminate\Http\Request;

class RestaurantFeeController extends Controller
{
    public function create()
    {
        $fee = RestaurantFee::first();
        return view('admin.fee.create')->with('fee',$fee);
    }

    public function store(Request $request)
    {
        RestaurantFee::updateOrCreate(['id' => 1], $request->all());
        return redirect()->back();
    }
}
