<?php

namespace App\Providers;

use App\Services\MovieService;
use Illuminate\Support\ServiceProvider;
use App\Services\TMDBService;
use App\Repositories\MovieRepository;

class TMDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TMDBService::class, function ($app) {
            return new TMDBService();
        });

        $this->app->singleton(MovieRepository::class, function ($app) {
            return new MovieRepository();
        });

        $this->app->singleton(MovieService::class, function ($app) {
            return new MovieService(
                $app->make(TMDBService::class),
                $app->make(MovieRepository::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
