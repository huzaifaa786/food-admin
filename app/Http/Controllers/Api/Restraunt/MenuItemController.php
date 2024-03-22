<?php

namespace App\Http\Controllers\api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuItemController extends Controller
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
        $menuItem = MenuItem::create([
            'restraunt_id' => auth()->user()->id,
            'discount_till_date' => Carbon::today()->addDays($request->discount_days)
        ] + $request->all());

        foreach ($request->extras as $extra) {
            Extra::create([
                'menu_item_id' => $menuItem->id
            ] + $request->all());
        }

        return Api::setResponse('menuItem', $menuItem);
    }

    /**
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function index(Request $request)
    {
        $menuItems = MenuItem::with('extras')->where('resturant_id', $request->restaurant_id)->get();
        return Api::setResponse('menu_items', $menuItems);
    }
}
