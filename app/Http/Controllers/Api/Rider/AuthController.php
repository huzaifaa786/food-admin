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

            // Update or store FCM token
            if ($request->has('fcm_token')) {
                $rider->fcm_token = $request->fcm_token;
                $rider->save();
            }

            // Generate token for the rider
            $rider->token = $rider->createToken("mobile", ['role:rider'])->plainTextToken;

            return Api::setResponse('rider', $rider);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    public function profile()
    {
        $rider = Driver::find(auth()->user()->id);
        $rider->restraunt;
        return Api::setResponse('rider', $rider);
    }

    /**
     * Method updatePassword
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:4'],
            'new_password' => ['required', 'string', 'min:6',]
        ]);

        $currentPasswordStatus = Hash::check($request->password, auth()->user()->password);
        if ($currentPasswordStatus) {
            $rider = Driver::find(auth()->user()->id);
            if (!$rider) {
                return Api::setResponse('error', 'rider not found');
            } else {
                $rider->update(['password' => $request->new_password]);
                return Api::setResponse('success', 'Password updated');
            }
        } else {
            return Api::setError('Wrong current password');
        }
    }

    public function toggleActive()
    {
        $rider = Driver::find(auth()->user()->id);
        $rider->update([
            'active' => !$rider->active
        ]);
        return Api::setResponse('rider', $rider);
    }
}
