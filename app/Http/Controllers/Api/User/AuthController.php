<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\ForgetPassword;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\IndividualForgetPassword;
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

            return Api::setResponse('user', $user);
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
     * Method updatePassword
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6'],
            'new_password' => ['required', 'string', 'min:6',]
        ]);

        $currentPasswordStatus = Hash::check($request->password, auth()->user()->password);
        if ($currentPasswordStatus) {
            $user = User::find(auth()->user()->id);
            if (!$user) {
                return Api::setResponse('error', 'user not found');
            } else {
                $user->update(['password' => $request->new_password]);
                return Api::setResponse('success', 'Password updated');
            }
        } else {
            return Api::setError('Wrong current password');
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


    /**
     * Method updateProdile
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function profileUpdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->update($request->all());
        return Api::setResponse('user', $user);
    }

    public function forgetPassword(Request $request)
    {
        try {
            $existingOtp = ForgetPassword::where('email', $request->email)->first();
            if ($existingOtp) {
                $existingOtp->delete();
            }
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $mailData = [
                    'title' => 'Food-Request Forget Password',
                    'name' => $user->name,
                    'otp' => $otp,
                ];
                ForgetPassword::create([
                    'email' => $request->email,
                    'otp' => $otp
                ]);
                Mail::to($request->email)->send(new IndividualForgetPassword($mailData));

                return Api::setResponse('mail', 'OTP sent successfully');
            } else {
                return Api::setError('Account does not exist');
            }
        } catch (\Exception $e) {
            return Api::setError('An error occurred: ' . $e->getMessage());
        }
    }
    public function verifyOtp(Request $request)
    {
        $otp = ForgetPassword::where('otp', $request->otp)->first();
        if ($otp) {
            $otp->delete();
            return Api::setResponse('otp', 'matched');
        } else {
            return Api::setError('Invalid OTP');
        }
    }
    public function verifyEmail(Request $request)
    {
        $existingEmail = User::where('email', $request->email)->first();
        if ($existingEmail) {
            return Api::setResponse('Existing User', $existingEmail->withToken());
        } else {
            return Api::setError('Email is not exist');
        }
    }
    public function forgetupdatePassword(Request $request)
    {

        $data = User::where('email', $request->email)->first();

        $data->update([
            'password' => $request->password
        ]);
        // toastr()->success('update successfully ');
        return Api::setResponse('update', $data);
    }
}
