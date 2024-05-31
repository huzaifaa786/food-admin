<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\RestaurantFee;
use Illuminate\Http\Request;

class RestaurantFeeController extends Controller
{
    public function fee()
    {
        $fee = RestaurantFee::first();
        return Api::setResponse('fee', $fee);
    }
}
