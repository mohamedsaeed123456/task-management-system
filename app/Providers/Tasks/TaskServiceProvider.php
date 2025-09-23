<?php

namespace App\Providers\Tasks;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Tasks\TaskServiceInterface;
use App\Services\Tasks\TaskService;
use App\Services\Tasks\Filters\TaskFilterHandler;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register TaskFilterHandler (no interface needed)
        $this->app->bind(TaskFilterHandler::class, TaskFilterHandler::class);
        
        // Bind TaskServiceInterface to TaskService implementation
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
