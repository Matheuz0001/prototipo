<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Forçar HTTPS quando atrás de proxy reverso (Ngrok/Cloudflare Tunnel)
        // ou quando APP_URL já usa HTTPS, ou em produção.
        $appUrl = config('app.url');

        if (
            str_contains($appUrl, 'https') ||
            str_contains($appUrl, 'ngrok') ||
            str_contains($appUrl, 'trycloudflare') ||
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
            env('APP_ENV') === 'production'
        ) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
