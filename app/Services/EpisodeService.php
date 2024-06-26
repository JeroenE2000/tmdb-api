<?php

namespace App\Services;

use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\SerieRepository;
use App\Services\TMDBService;

class EpisodeService
{

    public function __construct(
        protected EpisodeRepository $episodeRepository,
        protected SeasonRepository $seasonRepository,
        protected TMDBService $tmdbService,
        protected SerieRepository $serieRepository){}

    public function importEpisodesForSeries($serieId)
    {
        $seasons = $this->seasonRepository->findBySerieId($serieId);
        if($seasons->isEmpty()) {
            return 0;
        }
        $importedCount = 0;
        $tmdbId = $this->seasonRepository->getSerieId($seasons[0]->id);

        foreach ($seasons as $season) {
            $episodes = $this->tmdbService->getSeasonData($tmdbId, $season->season_number);
            if (isset($episodes['episodes'])) {
               $importedCount += $this->insertEpisodes($episodes['episodes'], $season->id);
            }
        }

        return $importedCount;
    }

    private function insertEpisodes($episodes, $seasonId): int {
        $importedCount = 0;
        foreach ($episodes as $episode) {
            $existingEpisode = $this->episodeRepository->findByTmdbId($episode['id']);

            if ($existingEpisode === null) {
                $episodesData[] = [
                    'tmdb_id' => $episode['id'],
                    'episode_number' => $episode['episode_number'],
                    'name' => $episode['name'],
                    'overview' => $episode['overview'],
                    'air_date' => $episode['air_date'],
                    'season_id' => $seasonId,
                ];

                $importedCount++;
            }
        }

        if (!empty($episodesData)) {
            $this->episodeRepository->insert($episodesData);
        }

        return $importedCount;
    }
}
