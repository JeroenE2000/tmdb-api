<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class TMDBService
{

    protected $apiKey;

    public function __construct() {
       $this->apiKey = config('services.tmdb.api_key');
    }

    public function fetchMovies($page = 1) {
        $response = Http::get('https://api.themoviedb.org/3/discover/movie', [
            'api_key' => $this->apiKey,
            'page' => $page
        ]);

        return $response->json();
    }

    public function fetchAllMovies($totalPages = 10)
    {
        $movies = [];

        for ($page = 1; $page <= $totalPages; $page++) {
            $response = $this->fetchMovies($page);
            $movies = array_merge($movies, $response['results']);
        }

        return $movies;
    }
}
