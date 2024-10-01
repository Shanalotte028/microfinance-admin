<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Model;

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
        //
        ResetPassword::createUrlUsing(function ($user, string $token) {
            // Check if the user is an instance of the Client or Admin model
            if ($user instanceof Client) {
                // Return the client reset password URL
                return url('client/password/reset', $token) . '?email=' . urlencode($user->email);
            } elseif ($user instanceof User) {
                // Return the admin reset password URL
                return url('admin/password/reset', $token) . '?email=' . urlencode($user->email);
            } else {
                // Default URL if it's neither a client nor an admin
                return url('password/reset', $token) . '?email=' . urlencode($user->email);
            }

            Model::preventLazyLoading();
        });
    }
}
