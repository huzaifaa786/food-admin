<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\LocationHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Poster;
use App\Models\Restraunt;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use stdClass;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $restaurants = Category::has('restaurants.menu_categories')->with([
            'restaurants' => function ($query) {
                $query->withAvg('ratings as rating', 'rating');
            }
        ])->get();

        $posters = Poster::all();
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        $restaurantsWithinRange = [];

        if ($address) {
            foreach ($restaurants as $category) {
                foreach ($category->restaurants as $restaurant) {
                    $distance = LocationHelper::calculateDistance($address->lat, $address->lng, $restaurant->lat, $restaurant->lng);
                    if ($distance <= ($restaurant->radius * 1000)) {
                        $restaurantsWithinRange[] = $restaurant;
                    }
                }
            }
        } else {
            foreach ($restaurants as $category) {
                foreach ($category->restaurants as $restaurant) {
                    $restaurantsWithinRange[] = $restaurant;
                }
            }
        }

        $response = new stdClass();
        $response->categories = $categories;
        $response->posters = $posters;
        $response->restaurants = $restaurantsWithinRange;

        return Api::setResponse('response', $response);

    }
}
