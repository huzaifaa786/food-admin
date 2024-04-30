<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            toastr()->success(' Login successfully ');
            return redirect()->intended('/dashboard');
        }
        toastr()->error('Incorrect email or password');
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
            'approve' => 'Wrong password or this account not approved yet.',
        ]);
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('adminlogin'); 
    }
}
