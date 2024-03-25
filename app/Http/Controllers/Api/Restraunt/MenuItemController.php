<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

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
                'menu_item_id' => $menuItem->id,
                'name' => $extra['name'],
                'price' => $extra['price']
            ]);
        }

        return Api::setResponse('menuItem', $menuItem);
    }

    /**
     * Method udpate
     *
     * @param $id $id [explicite description]
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $menuItem = MenuItem::find($id);
        $menuItem->update($request->all());

        if (!isEmpty($request->extras)) {
            foreach ($request->extras as $extra) {
                $mextra = Extra::find($extra->id);
                $mextra->update([
                    'menu_item_id' => $menuItem->id,
                    'name' => $extra['name'],
                    'price' => $extra['price']
                ]);
            }
        }

        return Api::setResponse('menuItem', $menuItem);
    }

    public function updateAvailability($id, Request $request)
    {
        $menuItem = MenuItem::find($id);
        $menuItem->toggleAvailable($request->availability);
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
        $menuItems = MenuItem::with('extras')->where('restraunt_id', auth()->user()->id)->get();
        return Api::setResponse('menu_items', $menuItems);
    }
}
