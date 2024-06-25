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

    public function findByIds(array $tmdbIds)
    {
        return Season::whereIn('tmdb_id', $tmdbIds)->get();
    }

    public function create(array $serieData)
    {
        return Season::create($serieData);
    }

    public function getNumberOfSeasons($serieId)
    {
        return Season::where('serie_id', $serieId)->count();
    }

    public function insert(array $seasonsData)
    {
        Season::insert($seasonsData);
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
