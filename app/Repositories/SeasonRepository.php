<?php

namespace App\Repositories;

use App\Models\Season;
use App\Interface\TMDBRepositoryInterface;

class SeasonRepository implements TMDBRepositoryInterface
{
    public function findById($tmdbId)
    {
        return Season::find($tmdbId);
    }

    public function create(array $serieData)
    {
        return Season::create($serieData);
    }

    public function getNumberOfSeasons($serieId)
    {
        return Season::where('serie_id', $serieId)->count();
    }

    public function getSerieId($seasonId)
    {
        $season = Season::find($seasonId);
        if ($season) {
            return $season->serie->tmdb_id;
        }
        return null;
    }
}
