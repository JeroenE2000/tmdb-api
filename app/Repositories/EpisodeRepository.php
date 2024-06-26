<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Interface\TMDBRepositoryInterface;

class EpisodeRepository implements TMDBRepositoryInterface
{
    public function findById($tmdbId)
    {
        return Episode::find($tmdbId);
    }

    public function create(array $serie)
    {
        return Episode::create($serie);
    }

    public function insert(array $episodes)
    {
        return Episode::insert($episodes);
    }

    public function findByTmdbId($tmdbId)
    {
        return Episode::where('tmdb_id', $tmdbId)->first();
    }
}
