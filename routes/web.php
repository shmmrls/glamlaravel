<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authenticated + verified + active users
Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile (required by Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::resource('cart', App\Http\Controllers\CartController::class);

    // Orders
    Route::resource('orders', App\Http\Controllers\OrderController::class);

    // Reviews
    Route::resource('reviews', App\Http\Controllers\ReviewController::class);
});

// Admin only routes
Route::middleware(['auth', 'verified', 'active', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // All custom product routes BEFORE resource
    Route::get('products/template', [App\Http\Controllers\Admin\ProductController::class, 'downloadTemplate'])
        ->name('products.template');
    Route::post('products/import', [App\Http\Controllers\Admin\ProductController::class, 'import'])
        ->name('products.import');
    Route::post('products/{id}/restore', [App\Http\Controllers\Admin\ProductController::class, 'restore'])
        ->name('products.restore');
    Route::delete('products/images/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])
        ->name('products.images.destroy');

    // Resource routes after
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
    Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class);
});

require __DIR__.'/auth.php';