<?php

namespace App\Repositories;

use App\Models\Serie;
use App\Interface\TMDBRepositoryInterface;

class SerieRepository implements TMDBRepositoryInterface
{

    public function findByTmdbId($tmdbId)
    {
        return Serie::where('tmdb_id', $tmdbId)->first();
    }

    public function findByIds(array $tmdbIds)
    {
        return Serie::whereIn('tmdb_id', $tmdbIds)->get();
    }

    public function findBySerieId($serieId)
    {
        return Serie::where('id', $serieId)->get('tmdb_id');
    }

    public function create(array $serie)
    {
        return Serie::create($serie);
    }

    public function insert(array $series)
    {
        return Serie::insert($series);
    }
}
