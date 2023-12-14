<?php

namespace App\Providers;

use App\Search\PostProvider;
use Illuminate\Support\ServiceProvider;
use Statamic\Statamic;

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
        // Statamic::vite('app', [
        //     'resources/js/cp.js',
        //     'resources/css/cp.css',
        // ]);

        PostProvider::register();
    }
}
