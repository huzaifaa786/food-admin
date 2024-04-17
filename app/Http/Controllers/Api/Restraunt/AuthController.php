<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestrauntCreateRequest;
use App\Http\Requests\RestrauntLoginRequest;
use App\Mail\IndividualForgetPassword;
use App\Models\ForgetPassword;
use App\Models\Restraunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
            $restraunt = Restraunt::find(auth()->user()->id);
            if (!$restraunt) {
                return Api::setResponse('error', 'restraunt not found');
            } else {
                $restraunt->update(['password' => $request->new_password]);
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
        $restraunt = Restraunt::with('category')->find(auth()->user()->id);
        return Api::setResponse('restraunt', $restraunt);
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
        $restraunt = Restraunt::find(auth()->user()->id);
        $restraunt->update($request->all());
        return Api::setResponse('restraunt', $restraunt);
    }
    public function forgetPassword(Request $request)
    {
        try {
            $existingOtp = ForgetPassword::where('email', $request->email)->first();
            if ($existingOtp) {
                $existingOtp->delete();
            }
            $restraunt = Restraunt::where('email', $request->email)->first();

            if ($restraunt) {
                $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $mailData = [
                    'title' => 'Restraunt-Request Forget Password',
                    'name' => $restraunt->name,
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
        $existingEmail = Restraunt::where('email', $request->email)->first();
        if ($existingEmail) {
            return Api::setResponse('Existing User', $existingEmail->withToken());
        } else {
            return Api::setError('Email is not exist');
        }
    }
    public function forgetupdatePassword(Request $request)
    {

        $data = Restraunt::where('email', $request->email)->first();

        $data->update([
            'password' => $request->password
        ]);
        // toastr()->success('update successfully ');
        return Api::setResponse('update', $data);
    }
}
