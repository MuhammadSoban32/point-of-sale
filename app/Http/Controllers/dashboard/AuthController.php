<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;        
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use DB;

class AuthController extends Controller
{
    public function login_vew(){
        return view('dashboard.login');
    }
    public function login(Request $request){
               // Validate the request
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if (\Auth::attempt($request->only('email','password'))) {
            return redirect("/");
        }

        return redirect("/login")->withErrors("Login details are not valid")->withInput();
 }

 public function logout(){
    \Session::flush();
    \Auth::logout();
    return redirect("/");
 }
}
