<?php

namespace App\Providers;

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
        // Force HTTPS hanya jika APP_URL diawali dengan https:// atau APP_ENV = production
        // Ini mencegah error asset saat running di local php artisan serve (HTTP)
        if (strpos(config('app.url'), 'https://') === 0 || config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
