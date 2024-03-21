<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestrauntCreateRequest;
use App\Http\Requests\RestrauntLoginRequest;
use App\Models\Restraunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create Restraunt
     * @param Request $request
     * @return Restraunt
     */
    public function createRestraunt(RestrauntCreateRequest $request)
    {
        try {
            $restraunt = Restraunt::create($request->all());

            $restraunt->token = $restraunt->createToken("mobile")->plainTextToken;

            return Api::setResponse('restraunt', $restraunt);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    /**
     * Login The Restraunt
     * @param Request $request
     * @return Restraunt
     */
    public function login(RestrauntLoginRequest $request)
    {
        try {

            if (!Auth::guard('auth:restraunt')->attempt($request->only(['email', 'password']))) {
                return Api::setError('Invalid credentials');
            }

            $restraunt = Restraunt::where('email', $request->email)->first();
            $restraunt->token = $restraunt->createToken("mobile")->plainTextToken;

            return Api::setResponse('restraunt', $restraunt);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
