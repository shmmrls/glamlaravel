<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// static informational pages
Route::view('/about', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/contact', 'contact')->name('contact');
Route::view('/shipping', 'shipping')->name('shipping');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy-policy');
Route::view('/terms-of-service', 'terms-of-service')->name('terms-of-service');

// Search routes - Level 1, 2, and 3 implementations
Route::get('/search/basic', [App\Http\Controllers\SearchController::class, 'searchBasic'])->name('search.basic');
Route::get('/search/model', [App\Http\Controllers\SearchController::class, 'searchModel'])->name('search.model');
Route::get('/search/scout', [App\Http\Controllers\SearchController::class, 'searchScout'])->name('search.scout');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'homeSearch'])->name('search');

// Products - publicly viewable (guests + customers + admins)
Route::resource('products', App\Http\Controllers\ProductController::class)->only(['index', 'show']);

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

    Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
    
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