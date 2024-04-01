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
        $address = UserAddress::where('user_id', auth()->user()->id)->where('active', true)->first();
        if($address)
            $address->update(['active' => false]);

        $maddress = UserAddress::find($request->address_id);
        if ($maddress)
            $maddress->update(['active' => true]);

        return Api::setResponse('address', $maddress);

    }
}
