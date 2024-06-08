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
        $categories = Category::with([
            'restaurants' => function ($query) {
                $query->withAvg('ratings as rating', 'rating');
            }
        ])->has('restaurants.menu_categories')->get();

        $posters = Poster::all();

        $address = UserAddress::where('user_id', auth()->user()->id)->first();

        if ($address) {
            foreach ($categories as $category) {
                $category->restaurants = $category->restaurants->filter(function ($restaurant) use ($address) {
                    $distance = LocationHelper::calculateDistance($address->lat, $address->lng, $restaurant->lat, $restaurant->lng);
                    return $distance <= ($restaurant->radius * 1000);
                })->values(); // Reset keys after filtering
            }
        }

        $response = new stdClass();
        $response->categories = $categories;
        $response->posters = $posters;

        return Api::setResponse('response', $response);
    }

}
