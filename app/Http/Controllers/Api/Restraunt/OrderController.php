<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function index()
   {
        $orders = Order::where('restraunt_id' , auth()->user()->id);
   }
}
