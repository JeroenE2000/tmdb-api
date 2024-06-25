<?php

namespace App\Services;

use App\Repositories\SerieRepository;
use App\Services\SeasonService;

class SerieService
{
    public function __construct(
        protected SerieRepository $serieRepository,
        protected TMDBService $tmdbService,
        protected SeasonService $seasonService
    ) {}

    public function importSeriesFromTMDB($page = 1)
    {
        $series = $this->tmdbService->fetchAll($page, 'tv');
        $importedCount = 0;

        foreach ($series as $serieData) {
            $tmdbId = $serieData['id'];

            $existingSerie = $this->serieRepository->findByTmdbId($tmdbId);
            if ($existingSerie === null) {
                $this->serieRepository->insert([
                    'tmdb_id' => $tmdbId,
                    'name' => $serieData['name'],
                    'overview' => $serieData['overview'],
                    'first_air_date' => $serieData['first_air_date'],
                    'poster_path' => $serieData['poster_path'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $importedCount++;

                $newSerie = $this->serieRepository->findByTmdbId($tmdbId);
                $this->seasonService->importSeasons($newSerie);
            } else {
                continue;
            }
        }

        return $importedCount;
    }


}

