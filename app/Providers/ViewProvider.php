<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $general_settings = GeneralSetting::select('logo', 'favicon', 'site_name')->first();
            $view->with('general_settings', $general_settings);
        });
    }
}
