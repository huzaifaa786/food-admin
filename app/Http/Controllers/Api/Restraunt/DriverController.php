<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverStoreRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use Intervention\Image\Colors\Rgb\Channels\Red;

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

    /**
     * Method deleteDriver
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function deleteDriver($id)
    {
        $driver = Driver::find($id);
        $driver->delete();
        return Api::setMessage('driver deleted successfully');
    }

    /**
     * Method updateDriver
     *
     * @param $id $id [explicite description]
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function udpateDriver($id, Request $request)
    {
        $driver = Driver::find($id);
        $driver->update($request->all());
        return Api::setResponse('driver', $driver);
    }

    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $drivers = Driver::all();
        return Api::setResponse('drivers', $drivers);
    }
}
