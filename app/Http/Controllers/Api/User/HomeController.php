<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\RestrauntStatus;
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
        $address = UserAddress::where('user_id', auth()->user()->id)->where('active', true)->first();

        $restaurants = Category::with([
            'restaurants' => function ($query) use ($address) {
                $query->where('status', RestrauntStatus::OPENED->value)
                    ->whereHas('menu_categories')
                    ->withAvg('ratings as rating', 'rating')
                ;
            }
        ])->get();

        $posters = Poster::whereHas('restraunt', function ($query) use ($address) {
            $query->whereHas('menu_categories', function ($subQuery) use ($address) {
                $subQuery->whereRaw("
                " . LocationHelper::calculateDistanceSql($address->lat, $address->lng, 'restraunts.lat', 'restraunts.lng') . " <= restraunts.radius * 1000
            ")
                    ->where('status', RestrauntStatus::OPENED->value);
            });
        })
            ->where('created_at', '>=', now()->subDay())
            ->get();

        $response = new stdClass();
        $response->categories = $categories;
        $response->posters = $posters;
        $response->restaurants = $restaurants;

        return Api::setResponse('response', $response);
    }


    // public function index()
    // {
    //     $categories = Category::all();

    //     $address = UserAddress::where('user_id', auth()->user()->id)->where('active', true)->first();

    //     // Ensure we have an address before proceeding with location-based filtering
    //     if ($address) {
    //         $restaurants = Restraunt::whereRaw("
    //             (" . LocationHelper::calculateDistanceSql($address->lat, $address->lng, 'restraunts.lat', 'restraunts.lng') . " <= restraunts.radius * 1000)
    //         ")
    //             ->where('status', RestrauntStatus::OPENED->value)
    //             ->with(['menu_categories', 'category', 'category.restaurants']) // Ensure category is loaded
    //             ->withAvg('ratings as rating', 'rating')
    //             ->get();
    //     } else {
    //         $restaurants = collect(); // Empty collection if no address
    //     }

    //     $posters = Poster::whereHas('restraunt', function ($query) use ($address) {
    //         if ($address) {
    //             $query->whereHas('menu_categories', function ($subQuery) use ($address) {
    //                 $subQuery->whereRaw("
    //                 " . LocationHelper::calculateDistanceSql($address->lat, $address->lng, 'restraunts.lat', 'restraunts.lng') . " <= restraunts.radius * 1000
    //             ")
    //                     ->where('status', RestrauntStatus::OPENED->value);
    //             });
    //         }
    //     })
    //         ->where('created_at', '>=', now()->subDay())
    //         ->get();

    //     $response = new \stdClass();
    //     $response->categories = $categories;
    //     $response->posters = $posters;
    //     $response->restaurants = $restaurants;

    //     return Api::setResponse('response', $response);
    // }
}
