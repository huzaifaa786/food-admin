<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $categories = Category::all();
        return Api::setResponse('categories', $categories);
    }
}
