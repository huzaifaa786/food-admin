<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
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
        $address = UserAddress::create([
            'user_id' => auth()->user()->id
        ] + $request->all());

        return Api::setResponse('address', $address);
    }

    /**
     * Method get
     *
     * @return void
     */
    public function get()
    {
        $addressess = UserAddress::where('user_id', auth()->user()->id)->get();
        return Api::setResponse('addressess', $addressess);
    }

    public function setMain(Request $request)
    {
        $addressess = UserAddress::where('user_id', auth()->user()->id)->get();
    }
}
