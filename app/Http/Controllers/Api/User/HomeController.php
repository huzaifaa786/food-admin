<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restraunt;
use Illuminate\Http\Request;
use stdClass;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['restaurants' => function ($query) {
            $query->has('menu_categories')->withAvg('ratings', 'rating');
        }])->get();

        $categoriesWithRestaurants = $categories->map(function ($category) {
            $category->restaurants->transform(function ($restaurant) {
                $restaurant->rating = $restaurant->ratings_avg_rating;
                unset($restaurant->ratings_avg_rating);
                return $restaurant;
            });
            return $category;
        });

        $response = new stdClass();
        $response->categories = $categories;
        $response->restaurants = $categoriesWithRestaurants;

        return Api::setResponse('response', $response);
    }
}
