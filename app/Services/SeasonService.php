<?php

namespace App\Services;

use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Services\EpisodeService;
use App\Services\TMDBService;

class SeasonService
{
    public function __construct(
        protected SeasonRepository $seasonRepository,
        protected EpisodeRepository $episodeRepository,
        protected EpisodeService $episodeService,
        protected TMDBService $tmdbService
    ) {}

    public function importSeasons($serie)
    {
        $tmdbId = $serie->tmdb_id;
        $seasonData = $this->tmdbService->getSerieData($tmdbId);
        if (isset($seasonData['seasons'])) {
            $seasonsData = [];

            foreach ($seasonData['seasons'] as $season) {
                $seasonsData[] = [
                    'tmdb_id' => $season['id'],
                    'serie_id' => $serie->id,
                    'season_number' => $season['season_number'],
                    'overview' => $season['overview'],
                    'air_date' => $season['air_date'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $this->seasonRepository->insert($seasonsData);

        }
    }
}
