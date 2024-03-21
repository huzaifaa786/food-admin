<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverStoreRequest;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Method storeDriver
     *
     * @param DriverStoreRequest $request [explicite description]
     *
     * @return void
     */
    public function storeDriver(DriverStoreRequest $request)
    {
        try {
            $driver = Driver::create([
                'restraunt_id' => auth()->id()
            ] + $request->all());

            return Api::setResponse('driver', $driver);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    public function index(){
        $drivers = Driver::all();
        return Api::setResponse('drivers', $drivers);
    }
}
