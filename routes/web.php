<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminGameController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminOrderController;

// 1. Public Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
Route::post('/accounts/{id}/wishlist', [AccountController::class, 'toggleWishlist'])->name('wishlist.toggle');

// 2. Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. User Dashboard Cabinet (Protected by Auth)
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
    Route::get('/transactions', [UserController::class, 'transactions'])->name('transactions');
    Route::get('/purchased', [UserController::class, 'purchased'])->name('purchased');
    Route::get('/deposit', [UserController::class, 'deposit'])->name('deposit');
    Route::post('/deposit', [UserController::class, 'processDeposit'])->name('deposit.process');
});

// 4. Cart & Checkout Routes (Session based, some require Auth)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::post('/buynow/{id}', [CartController::class, 'buyNow'])->name('buy-now');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('auth');
});

// 5. REST API Endpoints (Placed in web routes for seamless, zero-config availability)
Route::prefix('api')->group(function () {
    Route::get('/games', [ApiController::class, 'games']);
    Route::get('/accounts', [ApiController::class, 'accounts']);
    Route::get('/accounts/{id}', [ApiController::class, 'showAccount']);
});

// 6. Admin Control Panel (Protected by Auth and custom AdminMiddleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Resources
    Route::resource('games', AdminGameController::class);
    Route::resource('accounts', AdminAccountController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('coupons', AdminCouponController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
});

