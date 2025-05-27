<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\FarmerAuthController;
use App\Http\Controllers\BuyerAuthController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\PaddyTypeController;
use App\Http\Controllers\FarmerSellingPaddyTypesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\FarmerDashboardController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Public authentication routes
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])
        ->name('login')
        ->middleware('guest:admin');
    
    Route::post('login', [AdminAuthController::class, 'login'])
        ->middleware('guest:admin');
        
    Route::get('otp-verify', [AdminAuthController::class, 'showOTPVerificationForm'])
        ->name('otp.verify')
        ->middleware('guest:admin');
        
    Route::post('otp-verify', [AdminAuthController::class, 'verifyOTP'])
        ->name('otp.verify.submit')
        ->middleware('guest:admin');
        
    Route::post('logout', [AdminAuthController::class, 'logout'])
        ->name('logout');

    // Protected admin routes
    Route::middleware(['auth:admin'])->group(function () {
        // Dashboard
        Route::get('dashboard', function () {return view('admin.dashboard');})->name('dashboard');
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');  

        // Paddy management
        Route::resource('paddy', PaddyTypeController::class)->except(['show'])
            ->names([
                'index' => 'paddy.index',
                'create' => 'paddy.create',
                'store' => 'paddy.store',
                'edit' => 'paddy.edit',
                'update' => 'paddy.update',
                'destroy' => 'paddy.destroy'
            ]);

        // Farmer management
        Route::get('farmer', [FarmerController::class, 'index'])->name('farmer.index');
        Route::delete('farmer/{id}', [FarmerController::class, 'destroyFarmer'])->name('farmer.destroy');

        // Buyer management
        Route::get('buyer', [BuyerController::class, 'index'])->name('buyer.index');
        Route::delete('buyer/{id}', [BuyerController::class, 'destroy'])->name('buyer.destroy');

        // Farmer Paddy Selections
        Route::get('farmer-paddy-selections', [FarmerSellingPaddyTypesController::class, 'farmerSelections'])->name('farmer.paddy.selections');
        
        Route::delete('farmer-paddy-selections/{id}',[FarmerSellingPaddyTypesController::class, 'destroyFarmerSelectedPaddyType'])->name('farmer.paddy.delete');

        // Account management
        Route::get('account', [AdminDashboardController::class, 'account'])->name('account');
        Route::put('account', [AdminDashboardController::class, 'updateAccount'])->name('account.update');

        // Order management
        Route::prefix('orders')->name('orders.')->group(function() {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
            Route::put('/{id}/status', [AdminOrderController::class, 'preventStatusUpdate'])->name('update.status');
            Route::delete('/{id}', [AdminOrderController::class, 'preventDestroy'])->name('destroy');
            
            // Delivery routes
            Route::post('/{id}/start-delivery', [AdminOrderController::class, 'startDelivery'])->name('start-delivery');
            Route::post('/{id}/complete-delivery', [AdminOrderController::class, 'completeDelivery'])->name('complete-delivery');
        });
        
    });
});

// Farmer Routes
Route::prefix('farmer')->name('farmer.')->group(function () {
    // Authentication routes
    Route::get('login', [FarmerAuthController::class, 'showFarmerLogin'])->name('login');
    Route::post('login', [FarmerAuthController::class, 'login']);
    Route::get('register', [FarmerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [FarmerAuthController::class, 'register']);
    Route::post('logout', [FarmerAuthController::class, 'logout'])->name('logout');
    Route::post('/check-nic-unique', [FarmerAuthController::class, 'checkNicUnique']);

    // Password reset routes
    Route::get('forgot-password', [FarmerAuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [FarmerAuthController::class, 'sendResetLinkEmail'])->name('password.email'); 
    Route::get('reset-password/{token}', [FarmerAuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [FarmerAuthController::class, 'resetPassword'])->name('password.update');

    // Protected routes
    Route::middleware(['auth:farmer'])->group(function () {
        Route::get('dashboard', [FarmerController::class, 'dashboard'])->name('dashboard');

        // Paddy Listing
        Route::get('paddy-listing-form', [FarmerSellingPaddyTypesController::class, 'create'])->name('paddy.listing.form');
        Route::post('selling/paddy/store', [FarmerSellingPaddyTypesController::class, 'store'])->name('selling.paddy.store');
        Route::get('paddy-listing/{id}/edit', [FarmerSellingPaddyTypesController::class, 'edit'])->name('paddy.listing.edit');
        Route::put('paddy-listing/{id}', [FarmerSellingPaddyTypesController::class, 'update'])->name('paddy.listing.update');
        Route::delete('paddy-listing/{id}', [FarmerSellingPaddyTypesController::class, 'destroy'])->name('paddy.listing.destroy');
        Route::get('paddy-listing', [FarmerSellingPaddyTypesController::class, 'index'])->name('paddy.listing');

        // Account management
        Route::get('account', [FarmerDashboardController::class, 'account'])->name('account');
        Route::put('account', [FarmerDashboardController::class, 'updateAccount'])->name('account.update');

        // Orders
        Route::get('orders', [OrderController::class, 'farmerOrders'])->name('orders.index');
        Route::post('orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    });
});

// Buyer Routes
Route::prefix('buyer')->name('buyer.')->group(function () {
    // Authentication routes
    Route::get('login', [BuyerAuthController::class, 'showBuyerLogin'])->name('login');
    Route::post('login', [BuyerAuthController::class, 'buyerLogin']);
    Route::get('register', [BuyerAuthController::class, 'showBuyerRegisterForm'])->name('register');
    Route::post('register', [BuyerAuthController::class, 'buyerRegister']);
    Route::post('logout', [BuyerAuthController::class, 'logout'])->name('logout');
    Route::post('/check-buyer-nic-unique', [BuyerAuthController::class, 'checkNicUnique']);

    // OTP Verification
    Route::get('otp-verify', [BuyerAuthController::class, 'showOTPVerificationForm'])->name('otp.verify');
    Route::post('otp-verify', [BuyerAuthController::class, 'verifyOTP'])->name('otp.verify.submit');

    // Password reset
    Route::get('forgot-password', [BuyerAuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [BuyerAuthController::class, 'sendResetLinkEmail'])->name('password.email'); 
    Route::get('reset-password/{token}', [BuyerAuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [BuyerAuthController::class, 'resetPassword'])->name('password.update');

    // Protected routes
    Route::middleware(['auth:buyer'])->group(function () {
        Route::get('dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');
        
        // Products
        Route::get('products', [FarmerSellingPaddyTypesController::class, 'products'])->name('products');
        Route::get('products/{id}', [OrderController::class, 'show'])->name('products.show');

        // Account
        Route::get('account', [BuyerDashboardController::class, 'account'])->name('account');
        Route::put('account', [BuyerDashboardController::class, 'updateAccount'])->name('account.update');
        
        // Orders
        Route::get('product/{id}', [OrderController::class, 'showProductDetails'])->name('product.details');
        Route::post('place-order', [OrderController::class, 'placeOrder'])->name('place.order');
        Route::get('orders', [OrderController::class, 'listOrders'])->name('orders');
        Route::get('order/{id}', [OrderController::class, 'showOrderDetails'])->name('order.details');
        Route::post('orders/{id}/receive', [OrderController::class, 'receiveOrder'])->name('orders.receive');
        Route::patch('orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
    });
});

// BotMan route
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);