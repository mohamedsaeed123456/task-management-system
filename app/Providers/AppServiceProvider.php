<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\Auth\AuthServiceProvider;
use App\Providers\Tasks\TaskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Auth module
        $this->app->register(AuthServiceProvider::class);
        
        // Register Tasks module
        $this->app->register(TaskServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
