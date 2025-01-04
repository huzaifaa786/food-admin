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
        // Fetch the restaurant with related menu categories and items
        $restaurant = Restraunt::with([
            'menu_categories' => function ($query) {
                $query->whereHas('menu_items'); // Only include categories with menu items
            },
            'menu_categories.menu_items'
        ])->find($id);

        if (!$restaurant) {
            return Api::setError('Restaurant not found', 404);
        }

        // Fetch and process all menu items
        $menuItems = $restaurant->menu_categories->flatMap(function ($category) {
            return $category->menu_items;
        });

        $currentDay = now()->format('l'); // Current day, e.g., 'Monday'
        $currentDate = now()->toDateString(); // Current date, e.g., '2025-01-04'

        $menuItems->each(function ($item) use ($currentDay, $currentDate) {
            // Check and apply discounts
            if (
                $item->discount && // Discount exists
                $item->discount_till_date && // Discount end date exists
                $currentDate <= $item->discount_till_date  // Today is a discount day
            ) {
                // Apply discount
                $item->original_price = $item->price; // Store original price
                $item->price = $item->price - ($item->price * ($item->discount / 100));
                dd($item);
            }
        });

        // Add an "All" category with all menu items
        $allCategory = (object)[
            'name' => 'All',
            'ar_name' => 'الجميع',
            'restraunt_id' => $restaurant->id,
            'menu_items' => $menuItems
        ];
        $restaurant->menu_categories->prepend($allCategory);

        // Calculate and add the average rating for the restaurant
        $restaurant->rating = round(Rating::where('restraunt_id', $id)->avg('rating'), 1) ?: 0.0;

        return Api::setResponse('restaurant', $restaurant);
    }


}
