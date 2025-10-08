<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin_dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin_category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/admin_category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::get('/admin_category/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('/admin_category/create', [CategoryController::class, 'create'])->name('admin.category.create.post');
    Route::post('/admin_category/{category}/edit', [CategoryController::class, 'update'])->name('admin.category.edit.post');
    Route::delete('admin_cateogry/{category}/delete', [CategoryController::class, 'delete'])->name('admin.category.delete');

});

require __DIR__.'/auth.php';
