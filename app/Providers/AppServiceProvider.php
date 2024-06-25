<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
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

        Http::macro('tmdb', function() {
            return Http::withHeaders([
                'api_key' => config('services.tmdb.api_key')
            ])->baseUrl(config('services.tmdb.base_url'));
        });
    }
}
