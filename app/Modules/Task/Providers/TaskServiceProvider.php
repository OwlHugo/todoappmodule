<?php

namespace App\Modules\Task\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
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
        $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/web.php');
        
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../Http/Routes/api.php');
    }
} 