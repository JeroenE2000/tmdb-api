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
        $seasonsData = $this->seasonRepository->findBySerieId($serieId);
        $episodesData = [];
        $importedCount = 0;
        $tmdbId = $this->seasonRepository->getSerieId($seasonsData[0]->id);

        foreach ($seasonsData as $season) {
            $seasonData = $this->tmdbService->getSeasonData($tmdbId, $season->season_number);
            if (isset($seasonData['episodes'])) {
                $episodes = $seasonData['episodes'];

                foreach ($episodes as $episode) {
                    $existingEpisode = $this->episodeRepository->findByTmdbId($episode['id']);

                    if ($existingEpisode === null) {
                        $episodesData[] = [
                            'tmdb_id' => $episode['id'],
                            'episode_number' => $episode['episode_number'],
                            'name' => $episode['name'],
                            'overview' => $episode['overview'],
                            'air_date' => $episode['air_date'],
                            'season_id' => $season->id,
                        ];

                        $importedCount++;
                    }
                }

            }
        }

        if (!empty($episodesData)) {
            $this->episodeRepository->insert($episodesData);
        }

        return $importedCount;
    }
}
