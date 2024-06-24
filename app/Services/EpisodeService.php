<?php

namespace App\Services;

use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Services\TMDBService;

class EpisodeService
{
    protected $episodeRepository;
    protected $seasonRepository;
    protected $tmdbService;

    public function __construct(EpisodeRepository $episodeRepository, SeasonRepository $seasonRepository, TMDBService $tmdbService)
    {
        $this->episodeRepository = $episodeRepository;
        $this->seasonRepository = $seasonRepository;
        $this->tmdbService = $tmdbService;
    }

    public function saveEpisodes($seasonId, array $episodesData)
    {
        foreach ($episodesData as &$episodeData) {
            $episodeData['season_id'] = $seasonId;
        }
        $this->episodeRepository->insert($episodesData);
    }


    public function importEpisodes($season)
    {
        $serieId = $this->seasonRepository->getSerieId($season->id);
        $seasonData = $this->tmdbService->getSeasonData($serieId, $season->season_number);

        if (isset($seasonData['episodes'])) {
            $episodes = $seasonData['episodes'];
            $episodesData = [];

            foreach ($episodes as $episode) {
                $episodesData[] = [
                    'tmdb_id' => $episode['id'],
                    'episode_number' => $episode['episode_number'],
                    'name' => $episode['name'],
                    'overview' => $episode['overview'],
                    'air_date' => $episode['air_date'],
                ];
            }

            $this->saveEpisodes($season->id, $episodesData);
        }
    }

}
