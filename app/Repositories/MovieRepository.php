<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Interface\TMDBRepositoryInterface;

class MovieRepository implements TMDBRepositoryInterface
{

    public function findById($tmdbId)
    {
        return Movie::where('tmdb_id', $tmdbId)->first();
    }

    public function findByTmdbId($tmdbId)
    {
        return Movie::where('tmdb_id', $tmdbId)->first();
    }

    public function create(array $movieData)
    {
        return Movie::create($movieData);
    }
}
