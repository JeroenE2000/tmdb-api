<?php

namespace App\Providers;

use App\Interface\TMDBRepositoryInterface;
use App\Services\MovieService;
use Illuminate\Support\ServiceProvider;
use App\Services\TMDBService;
use App\Repositories\MovieRepository;
use App\Repositories\SerieRepository;

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

        $this->app->bind(TMDBRepositoryInterface::class, MovieRepository::class, SerieRepository::class);
        $this->app->bind(TMDBRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(TMDBRepositoryInterface::class, SerieRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
