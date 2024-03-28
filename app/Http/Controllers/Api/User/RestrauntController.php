<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Restraunt;
use Illuminate\Http\Request;

class RestrauntController extends Controller
{
    public function index()
    {
        $restaurants = Restraunt::all();
        return Api::setResponse('restaurants', $restaurants);
    }

    public function restaurantByCategory($id)
    {
        $restaurants = Restraunt::where('category_id', $id)->get();
        return Api::setResponse('restaurants', $restaurants);
    }

    public function restaurantDetail($id)
    {
        $restaurant = Restraunt::with('menu_categories')->find($id);
        return Api::setResponse('restaurant', $restaurant);
    }
}
