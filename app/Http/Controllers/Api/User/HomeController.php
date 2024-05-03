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
        $categories = Category::all();
        $restaurants = Category::has('restaurants.menu_categories')->with(['restaurants' => function ($query) {
            $query->whereHas('menu_categories')->withAvg('ratings', 'rating');
        }])->get();


        $response = new stdClass();
        $response->categories = $categories;
        $response->restaurants = $restaurants;

        return Api::setResponse('response', $response);
    }
}
