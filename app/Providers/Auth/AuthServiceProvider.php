<?php

namespace App\Providers\Auth;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Auth\AuthServiceInterface;
use App\Services\Auth\AuthService;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind AuthServiceInterface to AuthService implementation
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
