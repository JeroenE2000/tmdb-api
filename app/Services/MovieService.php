<?php

namespace App\Services;

use App\Repositories\MovieRepository;

class MovieService
{
    protected $tmdbService;
    protected $movieRepository;

    public function __construct(TMDBService $tmdbService, MovieRepository $movieRepository)
    {
        $this->tmdbService = $tmdbService;
        $this->movieRepository = $movieRepository;
    }

    public function importMoviesFromTMDB($totalPages = 10)
    {
        $movies = $this->tmdbService->fetchAll($totalPages, 'movie');
        $importedCount = 0;
        $processedIds = [];

        foreach ($movies as $movieData) {
            if (!in_array($movieData['id'], $processedIds)) {
                $this->movieRepository->create([
                    'tmdb_id' => $movieData['id'],
                    'title' => $movieData['title'],
                    'overview' => $movieData['overview'],
                    'release_date' => $movieData['release_date'],
                    'poster_path' => $movieData['poster_path'],
                ]);
                $processedIds[] = $movieData['id'];
                $importedCount++;
            }
        }

        return $importedCount;
    }
}
