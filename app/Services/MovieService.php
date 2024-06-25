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

        foreach ($movies as $movieData) {
            $tmdbId = $movieData['id'];

            $existingMovie = $this->movieRepository->findByTmdbId($tmdbId);

            if ($existingMovie === null) {
                $this->movieRepository->create([
                    'tmdb_id' => $tmdbId,
                    'title' => $movieData['title'],
                    'overview' => $movieData['overview'],
                    'release_date' => $movieData['release_date'],
                    'poster_path' => $movieData['poster_path'],
                ]);

                $processedIds[$tmdbId] = true;
                $importedCount++;
            }
        }

        return $importedCount;
    }
}
