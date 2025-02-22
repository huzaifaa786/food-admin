<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    /**
     * Method create
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function create(Request $request)
    {
        $menu_category =  MenuCategory::create([
            'restraunt_id' => auth()->user()->id
        ] + $request->all());
        return Api::setResponse('menu_category', $menu_category);
    }

    public function index()
    {
        $menuCategories = MenuCategory::where('restraunt_id', auth()->user()->id)->get();
        return Api::setResponse('menu_categories', $menuCategories);
    }
}
