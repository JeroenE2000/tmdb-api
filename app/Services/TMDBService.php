<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class TMDBService
{
    protected $apiKey;

    public function __construct() {
       $this->apiKey = config('services.tmdb.api_key');
    }

    public function fetchSingle($page = 1, $type = 'movie') {
        try {
            $response = Http::get("https://api.themoviedb.org/3/discover/{$type}", [
                'api_key' => $this->apiKey,
                'page' => $page
            ]);

            $this->handleResponse($response);

            return $response->json();
        } catch (RequestException $e) {
            Log::error('Error fetching single: ' . $e->getMessage());
            return null;
        }
    }

    public function getSerieData($id) {
        try {
            $response = Http::get("https://api.themoviedb.org/3/tv/{$id}", [
                'api_key' => $this->apiKey
            ]);

            $this->handleResponse($response);

            return $response->json();
        } catch (RequestException $e) {
            Log::error('Error fetching series data: ' . $e->getMessage());
            return null;
        }
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
     * @return array
     */
    public function fetchAll($totalPages = 10, $type = 'movie') {
        $seriesOrMovies = [];

        for ($page = 1; $page <= $totalPages; $page++) {
            $response = $this->fetchSingle($page, $type);
            if ($response !== null) {
                $seriesOrMovies = array_merge($seriesOrMovies, $response['results']);
            } else {
                Log::warning('Skipping page ' . $page . ' due to previous errors.');
            }
        }

        return $seriesOrMovies;
    }

    protected function handleResponse(Response $response) {
        if ($response->failed()) {
            throw new RequestException($response);
        }
    }
}
