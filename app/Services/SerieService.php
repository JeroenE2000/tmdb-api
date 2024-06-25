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
        foreach ($series as $serie) {
            $tmdbId = $serie['id'];

            $existingSerie = $this->serieRepository->findByTmdbId($tmdbId);
            if ($existingSerie === null) {
                $importedCount += $this->insertSeries($serie, $tmdbId);
            }
        }

        return $importedCount;
    }

    private function insertSeries($serie, $tmdbId): int {
        $importedCount = 0;

        $this->serieRepository->insert([
            'tmdb_id' => $tmdbId,
            'name' => $serie['name'],
            'overview' => $serie['overview'],
            'first_air_date' => $serie['first_air_date'],
            'poster_path' => $serie['poster_path'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $importedCount++;

        $newSerie = $this->serieRepository->findByTmdbId($tmdbId);
        $this->seasonService->importSeasons($newSerie);

        return $importedCount;
    }

}

