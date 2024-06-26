<?php

namespace App\Repositories;

use App\Models\Season;
use App\Interface\TMDBRepositoryInterface;

class SeasonRepository implements TMDBRepositoryInterface
{
    public function findByTmdbId($tmdbId)
    {
        return Season::where('tmdb_id', $tmdbId)->first();
    }

    public function findBySerieId($serieId)
    {
        return Season::where('serie_id', $serieId)->get();
    }

    public function create(array $season)
    {
        return Season::create($season);
    }

    public function insert(array $seasons)
    {
        Season::insert($seasons);
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
