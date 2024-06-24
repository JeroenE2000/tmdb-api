<?php

namespace App\Repositories;

use App\Models\Serie;
use App\Interface\TMDBRepositoryInterface;

class SerieRepository implements TMDBRepositoryInterface
{
    public function findById($tmdbId)
    {
        return Serie::find($tmdbId);
    }

    public function create(array $serieData)
    {
        return Serie::create($serieData);
    }
}
