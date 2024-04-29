<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
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

    public function graph(Request $request)
    {
        $dates = [];
        $counts = [];
        $date = Carbon::parse($request->date);
        $date2 = Carbon::parse($request->date);


        if ($request->duration == 1) {

            $newdate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
            $days = Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(7);
            $week = $days->format('Y-m-d');

            $sales = Order::selectRaw('DAY(created_at) as day, SUM(total_amount) as count')
                ->whereBetween('created_at', [$newdate, $week])
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            $dates = [];
            $counts = [];
            $currentDate = Carbon::createFromFormat('Y-m-d H:i:s', $date);

            for ($i = 0; $i < 7; $i++) {
                $count = 0;
                $s2 = $currentDate->format('d');

                foreach ($sales as $sale) {
                    if ($sale->day == $s2) {
                        $count = $sale->count;
                        break;
                    }
                }

                array_push($dates, $currentDate->toDateString());
                array_push($counts, $count);

                $currentDate->addDays(1);
                $s2 = $currentDate->format('d');
            }
        } elseif ($request->duration == 2) {
            $monthYear = Carbon::parse($request->month);
            $month = $monthYear->month;
            $year = $monthYear->year;
            $daysInMonth = $monthYear->daysInMonth;

            $sales = Order::selectRaw('DAY(created_at) as day, SUM(total_amount) as count')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $count = 0;
                foreach ($sales as $sale) {
                    if ($sale->day == $i) {
                        $count = $sale->count;
                        break;
                    }
                }
                array_push($dates, $i);
                array_push($counts, $count);
            }
        } elseif ($request->duration == 3) {
            $year = $request->year;

            $sales = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as count')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            for ($i = 1; $i <= 12; $i++) {
                $count = 0;
                foreach ($sales as $sale) {
                    if ($sale->month == $i) {
                        $count = $sale->count;
                        break;
                    }
                }
                array_push($dates, Carbon::createFromDate(null, $i, 1)->format('M'));
                array_push($counts, $count);
            }
        }

        return response()->json([
            'dates' => $dates,
            'count' => $counts,
        ]);
    }
}
