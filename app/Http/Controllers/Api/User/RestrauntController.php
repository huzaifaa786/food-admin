<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\LocationHelper;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Restraunt;
use Illuminate\Http\Request;

class RestrauntController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $restaurants = Restraunt::all();
        foreach ($restaurants as $res) {

            $time = LocationHelper::calculateTimeToReach($user->lat, $user->lng, $res->lat, $res->lng);

            $averageRating = Rating::where('restraunt_id', $res->id)->avg('rating');
            $res->time = $time;
            $res->rating = $averageRating;
        }
        return Api::setResponse('restaurants', $restaurants);
    }

    public function restaurantByCategory($id)
    {
        $restaurants = Restraunt::where('category_id', $id)->whereHas('menu_categories')->withAvg('ratings as rating', 'rating')->get();
        return Api::setResponse('restaurants', $restaurants);
    }

    public function restaurantDetail($id)
    {
        $restaurant = Restraunt::with(['menu_categories' => function ($query) {
            $query->has('menu_items');
        }])->find($id);

        $restaurant->rating = Rating::where('restraunt_id', $id)->avg('rating');
        return Api::setResponse('restaurant', $restaurant);
    }
}
