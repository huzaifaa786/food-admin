<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\RestaurantFee;
use App\Models\Restraunt;
use Illuminate\Http\Request;

use function React\Async\async;

class RestaurantFeeController extends Controller
{
    public function fee()
    {
        $fee = RestaurantFee::first();
        return Api::setResponse('fee', $fee);
    }

    public function updatePaymentStatus(Request $request)
    {
        $restaurant = Restraunt::find($request->id);
        $restaurant->update([
            'payment_status' => "Paid",
            "payment_intent" => $request->payment_intent
        ]);
        return Api::setResponse('restaurant', $restaurant);
    }
}
