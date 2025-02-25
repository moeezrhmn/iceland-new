<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
        require_once app_path('Helpers/helpers.php');
        require_once app_path('Helpers/Html.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
                            
    }
}
