<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function authorise(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $credentials = ['email' => $email, 'password' => $password];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        else {
            return back()->withErrors(array('email' => 'Invalid credentials given'))->withInput($request->input());
        }
    }

    public function logoutAdmin(Request $request){
        Auth::logout();
        return back();
    }
}
