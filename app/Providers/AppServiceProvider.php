<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gibakante nato ni kay ang bootstrap/app.php na ang bahala mo-detect sa URL
    }
}