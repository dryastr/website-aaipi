<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SubmenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once app_path("Helpers/SubmenuHelper.php");
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
