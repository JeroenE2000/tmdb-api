<?php

namespace App\Repositories;

use App\Models\Serie;
use App\Interface\TMDBRepositoryInterface;

class SerieRepository implements TMDBRepositoryInterface
{
    public function findById($tmdbId)
    {
        return Serie::where('tmdb_id', $tmdbId)->get();
    }

    public function findByTmdbId($tmdbId)
    {
        return Serie::where('tmdb_id', $tmdbId)->first();
    }

    public function findByIds(array $tmdbIds)
    {
        return Serie::whereIn('tmdb_id', $tmdbIds)->get();
    }

    public function create(array $serieData)
    {
        return Serie::create($serieData);
    }

    public function insert(array $serieData)
    {
        return Serie::insert($serieData);
    }
}
