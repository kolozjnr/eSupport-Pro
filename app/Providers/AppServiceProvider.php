<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // view()->composer('*', function ($view) {
        //     $settings = Cache::rememberForever('site_settings', function () {
        //         return Setting::first();
        //     });
        //     $view->with('settings', $settings);
        // });

            view()->composer('*', function ($view) {
            $settings = Cache::remember('site_settings', now()->addDay(), function () {
                $setting = Setting::first();
                // Handle case where no settings exist
                return $setting ?? new Setting();
            });
            $view->with('settings', $settings);
        });
        
    }
    
}
