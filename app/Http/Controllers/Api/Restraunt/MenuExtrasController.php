<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Extra;
use Illuminate\Http\Request;

class MenuExtrasController extends Controller
{
    /**
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function index(Request $request){
        $extras = Extra::where('menu_item_id', $request->menu_item_id)->get();
        return Api::setresponse('extras', $extras);
    }
}
