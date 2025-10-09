<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index() {
        if(Auth::check() && Auth::user()->role=='user') {
            return view('products.index');
        } else if(Auth::check() && Auth::user()->role=='admin') {
            return view('admin.dashboard');
        }
    }
}
