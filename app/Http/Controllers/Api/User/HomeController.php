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
        $address = UserAddress::where('user_id', auth()->user()->id)->first();

        $restaurants = Category::has('restaurants.menu_categories')
        ->whereHas('restaurants', function ($query) use ($address) {
            $query->whereRaw("
            (
                6371 * acos(
                    cos(radians(?)) * cos(radians(restraunts.lat)) *
                    cos(radians(restraunts.lng) - radians(?)) +
                    sin(radians(?)) * sin(radians(restraunts.lat))
                )
            ) <= restraunts.radius", [
                $address->lat,
                $address->lng,
                $address->lat
            ])
                ->where('status', RestrauntStatus::OPENED->value);
        })
            ->with([
                'restaurants' => function ($query) {
                    $query->withAvg('ratings as rating', 'rating');
                }
            ])
            ->get();

        $posters = Poster::whereHas('restraunt', function ($query) use ($address) {
            $query->whereHas('menu_categories', function ($subQuery) use ($address) {
                $subQuery->whereRaw("
            (
                6371 * acos(
                    cos(radians(?)) * cos(radians(restraunts.lat)) *
                    cos(radians(restraunts.lng) - radians(?)) +
                    sin(radians(?)) * sin(radians(restraunts.lat))
                )
            ) <= restraunts.radius", [
                    $address->lat,
                    $address->lng,
                    $address->lat
                ])
                    ->where('status', RestrauntStatus::OPENED->value);
            });
        })->where('created_at', '>=', now()->subDay())->get();

        $response = new stdClass();
        $response->categories = $categories;
        $response->posters = $posters;
        $response->restaurants = $restaurants;

        return Api::setResponse('response', $response);
    }
}
