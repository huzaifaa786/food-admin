<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(UserCreateRequest $request)
    {
        try {
            $user = User::create($request->all());
            $user->address =  UserAddress::create(['user_id' => $user->id] + $request->all());
            $user->token = $user->createToken("mobile")->plainTextToken;

           return Api::setResponse('user' , $user);

        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(UserLoginRequest $request)
    {
        try {

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return Api::setError('Invalid credentials');
            }

            $user = User::where('email', $request->email)->first();
            $user->token = $user->createToken("mobile")->plainTextToken;

            return Api::setResponse('user', $user);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
