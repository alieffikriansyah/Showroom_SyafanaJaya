<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register(function ($class) {
            if (strpos($class, 'App\\') === 0) {
                $relative = substr($class, 4);
                if (!strpos($relative, '\\')) {
                    $candidates = [
                        app_path($relative . '.php'),
                        app_path(lcfirst($relative) . '.php'),
                        app_path(strtolower($relative) . '.php'),
                    ];
                    foreach ($candidates as $file) {
                        if (file_exists($file)) {
                            require_once $file;
                            return;
                        }
                    }
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
