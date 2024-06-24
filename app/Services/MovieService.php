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
            $tmdbId = $movieData['id'];
            if (!isset($processedIds[$tmdbId])) {
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
