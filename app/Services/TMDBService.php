<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class TMDBService
{

    protected $apiKey;

    public function __construct() {
       $this->apiKey = config('services.tmdb.api_key');
    }

    /**
     * Fetches a single page of movie or series depending on the type param from the TMDB API
     * @param int $page
     * @param string $type
     */
    public function fetchSingle($page = 1, $type = 'movie') {
        $response = Http::get('https://api.themoviedb.org/3/discover/' .$type , [
            'api_key' => $this->apiKey,
            'page' => $page
        ]);

        return $response->json();
    }

    public function getSerieData ($id) {
        $response = Http::get('https://api.themoviedb.org/3/tv/' .$id , [
            'api_key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function getSeasonData($id, $seasonNumber)
    {
        $response = Http::get("https://api.themoviedb.org/3/tv/{$id}/season/{$seasonNumber}", [
            'api_key' => $this->apiKey,
        ]);

        return $response->json();
    }



    /**
     * Fetches all pages of movie or series depending on the type param from the TMDB API
     * @param int $totalPages
     * @param string $type
     */
    public function fetchAll($totalPages = 10, $type = 'movie')
    {
        $seriesOrMovies = [];

        for ($page = 1; $page <= $totalPages; $page++) {
            $response = $this->fetchSingle($page, $type);
            $seriesOrMovies = array_merge($seriesOrMovies, $response['results']);
        }

        return $seriesOrMovies;
    }
}
