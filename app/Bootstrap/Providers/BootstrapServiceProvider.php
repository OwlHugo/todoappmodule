<?php

namespace App\Bootstrap\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar repositories
        $this->app->bind(\App\Modules\Task\Repositories\TaskRepository::class, function ($app) {
            return new \App\Modules\Task\Repositories\TaskRepository(new \App\Modules\Task\Models\Task());
        });

        $this->app->bind(\App\Modules\User\Repositories\UserRepository::class, function ($app) {
            return new \App\Modules\User\Repositories\UserRepository(new \App\Modules\User\Models\User());
        });

        $this->app->bind(\App\Modules\Task\Repositories\TaskRepository::class, function ($app) {
            return new \App\Modules\Task\Repositories\TaskRepository(new \App\Modules\Task\Models\Task());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar middlewares
        $this->app['router']->aliasMiddleware('auth', \App\Bootstrap\Middleware\Authenticate::class);
        $this->app['router']->aliasMiddleware('guest', \App\Bootstrap\Middleware\RedirectIfAuthenticated::class);


        $this->loadModules();
    }

    /**
     * Load all modules automatically.
     */
    private function loadModules(): void
    {
        $modulesPath = app_path('Modules');
        
        if (!is_dir($modulesPath)) {
            return;
        }

        $modules = array_filter(glob($modulesPath . '/*'), 'is_dir');
        
        foreach ($modules as $module) {
            $moduleName = basename($module);
            $providerPath = $module . '/Providers/' . $moduleName . 'ServiceProvider.php';
            
            if (file_exists($providerPath)) {
                $providerClass = "App\\Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider";
                $this->app->register($providerClass);
            }
        }
    }
} 