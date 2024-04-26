<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Enums\OrderStatus;
use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $sales = [];
        $orders = Order::where('restraunt_id', auth()->user()->id)->get();
        foreach ($orders as $order) {
            if ($order->status ==OrderStatus::DELIVERED->value) {
                $data = [
                    'amount' => $order->total_amount,
                    'date' => Carbon::parse($order->updated_at)->format('Y-m-d'),
                ];
                $sales[] = $data;
            }
        }
        return Api::setResponse('sales', $sales);
    }
}
