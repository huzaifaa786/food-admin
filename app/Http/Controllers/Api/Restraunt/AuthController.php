<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestrauntCreateRequest;
use App\Http\Requests\RestrauntLoginRequest;
use App\Models\Restraunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

            $restraunt->token = $restraunt->createToken("mobile", ['role:restraunt'])->plainTextToken;

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

            $restraunt = Restraunt::where('email', $request->email)->first();

            if (!$restraunt || !Hash::check($request->password, $restraunt->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials'],
                ]);
            }
            $restraunt->token = $restraunt->createToken("mobile", ['role:restraunt'])->plainTextToken;

            return Api::setResponse('restraunt', $restraunt);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    /**
     * Method profile
     *
     * @return void
     */
    public function profile()
    {
        $restraunt = Restraunt::find(auth()->user()->id);
        return Api::setResponse('restraunt', $restraunt);
    }
}
