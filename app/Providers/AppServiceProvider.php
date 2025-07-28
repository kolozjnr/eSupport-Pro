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
                try {
                    // Test if cache is working
                    Cache::put('test_cache', 'working', 60);
                    $test = Cache::get('test_cache');
                    
                    if (!$test) {
                        \Log::error('Cache not working in production');
                    }
                    
                    $settings = Cache::rememberForever('site_settings', function () {
                        \Log::info('Cache miss - fetching settings from database');
                        return Setting::first();
                    });
                    
                } catch (\Exception $e) {
                    \Log::error('Cache error: ' . $e->getMessage());
                    // Fallback without cache
                    $settings = Setting::first();
                }
                
                $view->with('settings', $settings);
            });
        
    }
    
}
