<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\LocationHelper;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Restraunt;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use stdClass;

class RestrauntController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $restaurants = Restraunt::active()->get();
        foreach ($restaurants as $res) {

            $time = LocationHelper::calculateTimeToReach($user->lat, $user->lng, $res->lat, $res->lng);

            $averageRating = Rating::where('restraunt_id', $res->id)->avg('rating');
            $res->time = $time;
            $res->rating = $averageRating;
        }
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        $restaurantsWithinRange = [];
        if ($address) {
            foreach ($restaurants as $restaurant) {
                $distance = LocationHelper::calculateDistance($address->lat, $address->lng, $restaurant->lat, $restaurant->lng);
                if ($distance <= ($restaurant->radius * 1000)) {
                    $restaurantsWithinRange[] = $restaurant;
                }
            }
        } else {
            $restaurantsWithinRange = $restaurants;
        }
        return Api::setResponse('restaurants', $restaurantsWithinRange);
    }

    public function restaurantByCategory($id)
    {
        $restaurants = Restraunt::active()->where('category_id', $id)->whereHas('menu_categories')->withAvg('ratings as rating', 'rating')->get();
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        $restaurantsWithinRange = [];
        if ($address) {
            foreach ($restaurants as $restaurant) {
                $distance = LocationHelper::calculateDistance($address->lat, $address->lng, $restaurant->lat, $restaurant->lng);
                if ($distance <= ($restaurant->radius * 1000)) {
                    $restaurantsWithinRange[] = $restaurant;
                }
            }
        } else {
            $restaurantsWithinRange = $restaurants;
        }

        return Api::setResponse('restaurants', $restaurantsWithinRange);
    }

    public function restaurantInRange()
    {
        $address = UserAddress::where('user_id', auth()->user()->id)->first();
        $restaurants = Restraunt::active()->whereHas('menu_categories')->withAvg('ratings as rating', 'rating')->get();
        $restaurantsWithinRange = [];
        if ($address) {
            foreach ($restaurants as $restaurant) {
                $distance = LocationHelper::calculateDistance($address->lat, $address->lng, $restaurant->lat, $restaurant->lng);
                if ($distance <= ($restaurant->radius * 1000)) {
                    $restaurantsWithinRange[] = $restaurant;
                }
            }
        } else {
            $restaurantsWithinRange = $restaurants;
        }

        return Api::setResponse('restaurants', $restaurantsWithinRange);
    }


    public function restaurantDetail($id)
    {
        $restaurant = Restraunt::with([
            'menu_categories' => function ($query) {
                $query->has('menu_items');
            }
        ])->find($id);

        $menuItems = $restaurant->menu_categories->flatMap(function ($category) {
            return $category->menu_items;
        });

        $allCategory = new stdClass();
        $allCategory->name = 'All';
        $allCategory->ar_name = 'الجميع';
        $allCategory->restraunt_id = $restaurant->id;
        $allCategory->menu_items = $menuItems;

        $restaurant->menu_categories->prepend($allCategory);

        $restaurant->rating = Rating::where('restraunt_id', $id)->avg('rating');
        return Api::setResponse('restaurant', $restaurant);
    }

}
