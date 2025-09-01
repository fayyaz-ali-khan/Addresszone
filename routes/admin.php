
<?php

use App\Http\Controllers\admin\AddressController;
use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\BankAccountController;
use App\Http\Controllers\admin\BlogCategoryController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DocumentController;
use App\Http\Controllers\admin\EmailTemplateController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\SendNotificationController;
use App\Http\Controllers\admin\ServiceCategoryController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\GeneralSettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('redirectAuth')->controller(AuthController::class)->group(function () {

    Route::get('login', 'create')->name('login');
    Route::post('login', 'store')->name('store-login');
    Route::get('forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('reset-link-sent', 'createPasswordResetLink')->name('password-reset-link');
    Route::get('reset-link-sent', 'linkSent')->name('password-link-sent');
    Route::get('reset-password', 'resetPassword')->name('reset-password');
    Route::post('update-password', 'updatePassword')->name('update-password');
    Route::post('logout', 'logout')->name('logout')->middleware('auth:admin')->withoutMiddleware('redirectAuth');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::put('/{customer}/update-verification-status', [CustomerController::class, 'updateVerificationStatus'])->name('customers.update-verification-status');
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('coupons', CouponController::class)->except(['create', 'show']);
    Route::resource('reports', ReportController::class);
    Route::resource('addresses', AddressController::class);
    Route::resource('bank_accounts', BankAccountController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('general_settings', GeneralSettingController::class)->only(['index', 'update', 'store']);
    Route::resource('profile', ProfileController::class)->only(['update', 'edit']);
    Route::resource('service_categories', ServiceCategoryController::class)->except(['create', 'show']);
    Route::resource('email_templates', EmailTemplateController::class)->except(['show', 'destroy']);
    Route::resource('blogs', BlogController::class);
    Route::resource('blog-categories', BlogCategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('send-notifications', SendNotificationController::class)->only(['index', 'store', 'create']);
});
