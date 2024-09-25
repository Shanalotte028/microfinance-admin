<?php

namespace App\Providers;

use App\Services\CustomPasswordBroker;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 
        $this->app->singleton('auth.password.broker', function ($app) {
            return new CustomPasswordBroker(
                $app['auth.password.tokens'],
                $app['auth'],
                $app['auth.password'],
                $app['events']
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
