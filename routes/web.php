<?php

use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FAQController as AdminFAQController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TopUpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/order/{order_number}', [TopUpController::class, 'invoice'])->name('topup.invoice');
Route::post('/order/{order_number}/simulate-pay', [TopUpController::class, 'simulatePay'])->name('topup.simulate_pay');
Route::get('/locale/{lang}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');



use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:login')->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:register')->name('register.submit');

    // Forgot Password via Email OTP
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password/email', [ForgotPasswordController::class, 'sendOtpEmail'])->name('password.email');
    Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify.form');
    Route::post('/forgot-password/change-email', [ForgotPasswordController::class, 'changeEmailAndResendOtp'])->name('password.change_email');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    // Official Google OAuth 2.0
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

use App\Http\Controllers\Customer\ProfileController;

/*
|--------------------------------------------------------------------------
| Authenticated User Top Up, Profile & Portal
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/topup/{slug}', [TopUpController::class, 'show'])->name('topup.show');
    Route::post('/topup/{slug}/order', [TopUpController::class, 'checkout'])->middleware('throttle:30,1')->name('topup.checkout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Control Center (Role: admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');

    // Games Management
    Route::get('/games', [AdminGameController::class, 'index'])->name('games.index');
    Route::post('/games', [AdminGameController::class, 'store'])->name('games.store');
    Route::put('/games/{game}', [AdminGameController::class, 'update'])->name('games.update');
    Route::post('/games/{game}/toggle', [AdminGameController::class, 'toggleStatus'])->name('games.toggle');

    // Products / Denominations Management
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::post('/products/{product}/toggle', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // FAQs Management
    Route::get('/faqs', [AdminFAQController::class, 'index'])->name('faqs.index');
    Route::post('/faqs', [AdminFAQController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/{faq}', [AdminFAQController::class, 'update'])->name('faqs.update');
    Route::post('/faqs/{faq}/toggle', [AdminFAQController::class, 'toggleStatus'])->name('faqs.toggle');
    Route::delete('/faqs/{faq}', [AdminFAQController::class, 'destroy'])->name('faqs.destroy');

    // Orders Management & Fulfillment
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Activity Logs & WAF Defense Monitoring
    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');

    // Users Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-role', [\App\Http\Controllers\Admin\UserController::class, 'toggleRole'])->name('users.toggle_role');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Site Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

