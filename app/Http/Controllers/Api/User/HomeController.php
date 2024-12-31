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

        \DB::enableQueryLog();
        $restaurants = Category::has('restraunts.menu_categories')
        ->whereHas('restaurants', function ($query) use ($address) {
            $query->where(function ($subQuery) use ($address) {
                $subQuery->whereRaw("(
                " . LocationHelper::calculateDistanceSql($address->lat, $address->lng, 'restraunts.lat', 'restraunts.lng') . " <= restraunts.radius * 1000
            )");
            })
            ->where('status', RestrauntStatus::OPENED->value);
        })
            ->with([
            'restraunts' => function ($query) {
                    $query->withAvg('ratings as rating', 'rating');
                }
            ])
            ->get();

        dd(\DB::getQueryLog());


        $posters = Poster::whereHas('restraunt', function ($query) use ($address) {
            $query->whereHas('menu_categories', function ($subQuery) use ($address) {
                $subQuery->whereRaw("
            (
                6371 * acos(
                    cos(radians(?)) * cos(radians(restraunts.lat)) *
                    cos(radians(restraunts.lng) - radians(?)) +
                    sin(radians(?)) * sin(radians(restraunts.lat))
                )
            ) <= restraunts.radius / 1000", [
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
