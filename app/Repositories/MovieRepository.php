<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Interface\TMDBRepositoryInterface;

class MovieRepository implements TMDBRepositoryInterface
{

    public function findByTmdbId($tmdbId)
    {
        return Movie::where('tmdb_id', $tmdbId)->first();
    }

    public function create(array $movie)
    {
        return Movie::create($movie);
    }

    public function insert(array $movies)
    {
        return Movie::insert($movies);
    }
}
