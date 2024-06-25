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

    public function create(array $serieData)
    {
        return Episode::create($serieData);
    }

    public function insert(array $episodesData)
    {
        return Episode::insert($episodesData);
    }

    public function findByTmdbId($tmdbId)
    {
        return Episode::where('tmdb_id', $tmdbId)->first();
    }
}
