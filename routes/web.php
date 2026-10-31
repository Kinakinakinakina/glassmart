<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home', [
    'categories' => \App\Models\Category::withCount('products')->orderBy('name')->get(),
    'featured'   => \App\Models\Product::with('category')
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get(),
    // a different slice of the catalog for the "New arrivals" rail
    'newArrivals' => \App\Models\Product::where('is_active', true)
        ->latest()
        ->skip(8)
        ->take(5)
        ->get(),
]))->name('home');

// Storefront (public — guests may browse).
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Guests only: register and login.
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// Authenticated users.
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shopping is customer-only — admins are admin-only (no cart/checkout/orders).
    Route::middleware('role:customer')->group(function () {
        // Cart (session-based).
        Route::get('cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('cart/{product:slug}', [CartController::class, 'store'])->name('cart.store');
        Route::patch('cart/{product:slug}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('cart/{product:slug}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Checkout.
        Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout.create');
        Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

        // Orders (own).
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });
});

// Admins only.
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    });
