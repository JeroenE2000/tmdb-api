<?php

namespace App\Services;

use App\Repositories\MovieRepository;
use App\Services\TMDBService;

class MovieService
{
    protected $movieRepository;
    protected $tmdbService;

    public function __construct(MovieRepository $movieRepository, TMDBService $tmdbService)
    {
        $this->movieRepository = $movieRepository;
        $this->tmdbService = $tmdbService;
    }

    public function importMoviesFromTMDB($totalPages = 10)
    {
        $movies = $this->tmdbService->fetchAll($totalPages, 'movie');
        $importedCount = 0;
        $processedIds = [];

        foreach ($movies as $movie) {
            $tmdbId = $movie['id'];

            $existingMovie = $this->movieRepository->findByTmdbId($tmdbId);

            if ($existingMovie === null) {
                $this->movieRepository->create([
                    'tmdb_id' => $tmdbId,
                    'title' => $movie['title'],
                    'overview' => $movie['overview'],
                    'release_date' => $movie['release_date'],
                    'poster_path' => $movie['poster_path'],
                ]);

                $processedIds[$tmdbId] = true;
                $importedCount++;
            }
        }

        return $importedCount;
    }
}
