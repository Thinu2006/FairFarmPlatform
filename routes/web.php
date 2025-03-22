<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\FarmerAuthController;
use App\Http\Controllers\BuyerAuthController;
use App\Http\Controllers\PaddyTypeController;
use App\Http\Controllers\FarmerSellingPaddyTypesController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin authentication routes
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin protected routes (requires admin authentication)
    Route::middleware(['auth:admin'])->group(function () {
        // Dashboard
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Paddy management routes
        Route::get('paddy', [PaddyTypeController::class, 'index'])->name('paddy.index');
        Route::get('paddy/create', [PaddyTypeController::class, 'create'])->name('paddy.create');
        Route::post('paddy', [PaddyTypeController::class, 'store'])->name('paddy.store');
        Route::get('paddy/{id}/edit', [PaddyTypeController::class, 'edit'])->name('paddy.edit');
        Route::put('paddy/{id}', [PaddyTypeController::class, 'update'])->name('paddy.update');
        Route::delete('paddy/{id}', [PaddyTypeController::class, 'destroy'])->name('paddy.destroy');

        // Farmer management routes
        Route::get('farmer', [FarmerController::class, 'index'])->name('farmer.index');
        Route::delete('farmer/{id}', [FarmerController::class, 'destroy'])->name('farmer.destroy');

        // Buyer management routes
        Route::get('buyer', [BuyerController::class, 'index'])->name('buyer.index');
        Route::delete('buyer/{id}', [BuyerController::class, 'destroy'])->name('buyer.destroy');
    });
});

// Farmer Routes
Route::prefix('farmer')->name('farmer.')->group(function () {
    // Farmer authentication routes
    Route::get('login', [FarmerAuthController::class, 'showFarmerLogin'])->name('login');
    Route::post('login', [FarmerAuthController::class, 'login']);
    Route::get('register', [FarmerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [FarmerAuthController::class, 'register']);
    Route::post('logout', [FarmerAuthController::class, 'logout'])->name('logout');

    // Protected routes with the fixed middleware
    Route::middleware(['auth:farmer'])->group(function () {
        Route::get('dashboard', [FarmerController::class, 'dashboard'])->name('dashboard');

        // Paddy Listing Routes
        Route::get('paddy-listing-form', [FarmerSellingPaddyTypesController::class, 'create'])->name('paddy.listing.form');
        Route::post('selling/paddy/store', [FarmerSellingPaddyTypesController::class, 'store'])->name('selling.paddy.store');
        Route::get('paddy-listing/{id}/edit', [FarmerSellingPaddyTypesController::class, 'edit'])->name('paddy.listing.edit');
        Route::put('paddy-listing/{id}', [FarmerSellingPaddyTypesController::class, 'update'])->name('paddy.listing.update');
        Route::delete('paddy-listing/{id}', [FarmerSellingPaddyTypesController::class, 'destroy'])->name('paddy.listing.destroy');
        Route::get('paddy-listing', [FarmerSellingPaddyTypesController::class, 'index'])->name('paddy.listing');
    });
});

// Buyer Routes
Route::prefix('buyer')->name('buyer.')->group(function () {
    Route::get('login', [BuyerAuthController::class, 'showBuyerLogin'])->name('login');
    Route::post('login', [BuyerAuthController::class, 'buyerLogin']);
    Route::get('register', [BuyerAuthController::class, 'showBuyerRegisterForm'])->name('register');
    Route::post('register', [BuyerAuthController::class, 'buyerRegister']);
    Route::post('logout', [BuyerAuthController::class, 'logout'])->name('logout');

    // OTP Verification Routes
    Route::get('otp-verify', [BuyerAuthController::class, 'showOTPVerificationForm'])->name('otp.verify');
    Route::post('otp-verify', [BuyerAuthController::class, 'verifyOTP'])->name('otp.verify.submit');

    // Protected routes with middleware
    Route::middleware(['auth:buyer'])->group(function () {
        Route::get('dashboard', function () {
            return view('buyer.dashboard');
        })->name('dashboard');
    });
});