<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function saletable()
    {
        $saledata = [];
        $totalAmount = 0;
        return view('admin.Sales.index')->with('saledata', $saledata)->with('totalAmount', $totalAmount);
    }

    public function salestable(Request $request)
    {
        $start_date = $request->input('start_date', date('Y-m-d'));
        $end_date = $request->input('end_date', date('Y-m-d'));

        if ($start_date == $end_date) {
            $saledata = Order::whereDate('created_at', $start_date)
                ->with('restraunt')
                ->get();


            return view('admin.Sales.index')->with([
                'saledata' => $saledata,
                'startDate' => $start_date,
                'endDate' => $end_date
            ]);
        } else {
            $saledata = Order::whereBetween('created_at', [$start_date, $end_date])
                ->with('restraunt')
                ->get();


            return view('admin.Sales.index')->with([
                'saledata' => $saledata,
                'startDate' => $start_date,
                'endDate' => $end_date
            ]);
        }
    }
}
