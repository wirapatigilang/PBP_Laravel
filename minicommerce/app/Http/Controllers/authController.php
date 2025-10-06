<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class authController extends Controller
{

    public function register() {
        return view('register');
    }

    public function login() {
        return view('login');
    }

    public function registerPost (Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        if($request->password !== $request->password_confirmation) 
            return redirect(route('register'))->with('error', '*Password and Confirm Password do not match');
        

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = ModelsUser::create($data);
        if(!$user)
            return redirect(route('register'))->with('error', 'Registeration Failed');
        return redirect(route('login'))->with('success', 'Registeration Successful. Please Login');

    }

    public function loginPost (Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
        return redirect(route('login'))->with("error", "Login Details are Not Valid");
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    

}


