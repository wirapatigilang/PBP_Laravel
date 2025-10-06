<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/register', [authController::class, 'register'])->name('register');
Route::post('/register', [authController::class, 'registerPost'])->name('post.register');
Route::get('/login', [authController::class, 'login'])->name('login');
Route::post('/login', [authController::class, 'loginPost'])->name('post.login');
Route::get('/logout', [authController::class, 'logout'])->name('logout');



