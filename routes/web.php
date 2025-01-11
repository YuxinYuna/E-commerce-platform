<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\RoleMiddleware;

// Home page (accessible to guests and logged-in users)
Route::get('/home', [ShopController::class, 'index'])->name('home');
Route::get('/', [ShopController::class, 'index'])->name('home');

// Registration Routes for Admin and Customer
Route::get('/register/{role}', [RegisterController::class, 'showRegistrationForm'])->name('register.role');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Login Routes with Role-Based Login Views (Admin or Customer)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login.role');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Password Confirmation Route
Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);

// Customer (Buyer) Routes, accessible only by users with the 'customer' role
Route::middleware(['auth', RoleMiddleware::class . ':customer'])->group(function () {
    Route::get('/account/{section}', [ShopController::class, 'account'])->name('account');
    Route::put('/account/profile/update', [ShopController::class, 'updateProfile'])->name('profile.update');
    Route::post('/cart/update/{product}', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{product}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [ShopController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/cart/add/{product}', [ShopController::class, 'add'])->name('cart.add');
    Route::delete('/customer/orders/{order}', [ShopController::class, 'destroyOrder'])->name('customer.orders.destroy');

});

// Admin Routes, accessible only by users with the 'admin' role
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
    Route::put('/admin/orders/{order}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
    // Products Management Routes
    // Products Management Routes within AdminController
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
});
