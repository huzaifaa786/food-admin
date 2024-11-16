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
                $query->where(function ($subQuery) use ($address) {
                    $subQuery->whereRaw("(
                        " . LocationHelper::calculateDistanceSql($address->lat, $address->lng, 'restaurants.lat', 'restaurants.lng') . " <= restaurants.radius * 1000
                    )")
                        ->where('restaurants.status', RestrauntStatus::OPENED->value);
                });
            })
            ->with([
                'restaurants' => function ($query) {
                    $query->withAvg('ratings as rating', 'rating');
                }
            ])
            ->get();

        $categories = $categories->filter(function ($category) use ($restaurants) {
            return $restaurants->where('id', $category->id)->isNotEmpty();
        });

        $posters = Poster::whereHas('category', function ($query) use ($restaurants) {
            $query->whereIn('id', $restaurants->pluck('category_id'));
        })->get();

        $response = new stdClass();
        $response->categories = $categories;
        $response->posters = $posters;
        $response->restaurants = $restaurants;

        return Api::setResponse('response', $response);
    }
}
