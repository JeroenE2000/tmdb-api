<?php

namespace App\Services;

use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\SerieRepository;

class SeasonService
{
    protected $seasonRepository;
    protected $episodeService;
    protected $tmdbService;

    public function __construct(
        SeasonRepository $seasonRepository,
        EpisodeService $episodeService,
        TMDBService $tmdbService
    ) {
        $this->seasonRepository = $seasonRepository;
        $this->episodeService = $episodeService;
        $this->tmdbService = $tmdbService;
    }

    public function saveSeason($serieId, array $seasonData)
    {

        $season = $this->seasonRepository->findById($seasonData['tmdb_id']);
        if (!$season) {
            $seasonData['serie_id'] = $serieId;
            return $this->seasonRepository->create($seasonData);
        }
       return;
    }

    public function importSeason($serie)
    {
        $tmdbId = $serie->tmdb_id;
        $seasonData = $this->tmdbService->getSerieData($tmdbId);

        if (isset($seasonData['seasons'])) {
            foreach ($seasonData['seasons'] as $season) {
                $newSeason = $this->saveSeason($serie->id, [
                    'tmdb_id' => $season['id'],
                    'season_number' => $season['season_number'],
                    'overview' => $season['overview'],
                    'air_date' => $season['air_date'],
                ]);

                if ($newSeason) {
                    $this->episodeService->importEpisodes($newSeason);
                }
            }
        }
    }

}
