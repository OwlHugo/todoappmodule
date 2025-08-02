<?php

namespace App\Modules\Auth\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
        
        // Carregar rotas API com prefixo
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../Http/Routes/api.php');
    }
} 