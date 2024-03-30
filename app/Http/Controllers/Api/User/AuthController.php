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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            $user->token = $user->createToken("mobile", ['role:user'])->plainTextToken;

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

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials'],
                ]);
            }

            $user->token = $user->createToken("mobile", ['role:user'])->plainTextToken;

            return Api::setResponse('user', $user);
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
        $user = User::find(auth()->user()->id);
        return Api::setResponse('user', $user);
    }

}
