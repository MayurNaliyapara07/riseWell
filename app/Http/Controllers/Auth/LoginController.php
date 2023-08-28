<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            $userStatus = Auth::User()->status;
            if($userStatus=='1') {
                return redirect(url('home'))->with('success','login successfully.');
            }else{
                Auth::logout();
                Session::flush();
                return redirect(url('login'))->withError('You account temporary blocked. please contact to admin');
            }

        }
        return redirect(url('login'))->withError('The provided credentials do not match our records.');


    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login');
    }

}

