<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL; // <-- Add this import
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS for all generated URLs in Codespaces / proxy environments
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}