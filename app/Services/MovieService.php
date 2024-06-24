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

    public function importMoviesFromTMDB($totalPages = 10, $type = 'movie')
    {
        $movies = $this->tmdbService->fetchAll($totalPages, $type);
        $importedCount = 0;

        foreach ($movies as $movieData) {
            $existingMovie = $this->movieRepository->findById($movieData['id']);
            if (!$existingMovie) {
                $this->movieRepository->create([
                    'tmdb_id' => $movieData['id'],
                    'title' => $movieData['title'],
                    'overview' => $movieData['overview'],
                    'release_date' => $movieData['release_date'],
                    'poster_path' => $movieData['poster_path'],
                ]);
                $importedCount++;
            }
        }

        return $importedCount;
    }
}
