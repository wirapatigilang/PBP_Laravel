<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AdminCheckoutController;

// ---------------- Home / Root URL ----------------
Route::get('/', [ProductController::class, 'index'])->name('home');

// ---------------- Public ----------------
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// ---------------- Dashboard (user) ----------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ---------------- Profile ----------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------- Cart ----------------
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
});

// ---------------- Checkout ----------------
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');

    // ✅ Tambahan: route POST menuju method place() dengan alias checkout.store
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.store');

    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('/orders/{order}/success', [CheckoutController::class, 'success'])->name('orders.success');
});

// ---------------- Admin ----------------
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });

    // Products
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    });

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminCheckoutController::class, 'orders'])->name('admin.orders.index');
        Route::get('/{order}', [AdminCheckoutController::class, 'orderDetail'])->name('admin.orders.detail');
        Route::put('/{order}/update-status', [AdminCheckoutController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
        Route::put('/items/{item}/update-status', [AdminCheckoutController::class, 'updateItemStatus'])->name('admin.orders.updateItemStatus');
    });
});

// ---------------- Auth scaffolding (Breeze/Fortify/Jetstream) ----------------
require __DIR__ . '/auth.php';
