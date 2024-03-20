<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class Report
{
    public static function MonthlyEvent($month, $year, $userId)
    {
        $start = Carbon::createFromDate($year, $month)->startOfMonth();
        $end = Carbon::createFromDate($year, $month)->endOfMonth();
    
        $events = Event::where('user_id', $userId)
            ->whereBetween('created_at', [$start, $end])
            ->with('payments')
            ->get();
    
        $result = [];
    
        foreach ($events as $event) {
            $obj = new stdClass();
            $obj->event_name = $event->event_name;
            $obj->event_type = $event->event_type;
    
            // Calculate total amount for the event
            $obj->amount = $event->payments->sum('amount');
    
            $result[] = $obj;
        }
    
        return $result;
    }
    
   
}
