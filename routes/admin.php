
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\DocumentController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\AddressController;
use App\Http\Controllers\admin\BankAccountController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\auth\AuthController;

Route::prefix('admin')->group(function(){

    Route::controller(AuthController::class)->group(function(){
        Route::get('login','login');
        Route::get('forgot-password','forgotPassword');
        Route::get('reset-link-sent','resetLinkSent');
    });


    Route::get('/dashboard',DashboardController::class)->name('dashboard');
    Route::resource('customers',CustomerController::class);
    Route::resource('orders',OrderController::class);
    Route::resource('documents',DocumentController::class);
    Route::resource('services',ServiceController::class);
    Route::resource('coupons',CouponController::class);
    Route::resource('reports',ReportController::class);
    Route::resource('addresses',AddressController::class);
    Route::resource('bank_accounts',BankAccountController::class);
    Route::resource('currencies',CurrencyController::class);
});