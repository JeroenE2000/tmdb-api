<?php

namespace App\Providers;

use App\Interface\TMDBRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\TMDBService;
use App\Repositories\MovieRepository;
use App\Repositories\SerieRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;

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

        $this->app->bind(TMDBRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(TMDBRepositoryInterface::class, SerieRepository::class);
        $this->app->bind(TMDBRepositoryInterface::class, SeasonRepository::class);
        $this->app->bind(TMDBRepositoryInterface::class, EpisodeRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
