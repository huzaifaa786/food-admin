<?php

namespace App\Http\Controllers\Api\Rider;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestrauntLoginRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(RestrauntLoginRequest $request)
    {
        try {

            $rider = Driver::where('email', $request->email)->first();

            if (!$rider || !Hash::check($request->password, $rider->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials'],
                ]);
            }
            $rider->token = $rider->createToken("mobile", ['role:rider'])->plainTextToken;

            return Api::setResponse('rider', $rider);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
