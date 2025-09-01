<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    if (Auth::guard('admin')->check()) {
        return to_route('admin.dashboard', status: 301);
    }

    return to_route('admin.login');
});
