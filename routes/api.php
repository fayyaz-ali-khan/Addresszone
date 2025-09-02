<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\BlogCategoryController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\ServiceCategoryController;
use App\Http\Controllers\Api\V1\ServiceController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/auth/reset-password', [PasswordResetController::class, 'reset']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::prefix('v1')->group(function () {
    Route::apiResource('service-categories', ServiceCategoryController::class)->only(['index', 'show']);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::prefix('blogs-categories')->controller(BlogCategoryController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{param}', 'show');
    });
});
