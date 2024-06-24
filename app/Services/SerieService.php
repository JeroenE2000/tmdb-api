<?php

namespace App\Services;

use App\Repositories\SerieRepository;
use App\Services\SeasonService;

class SerieService
{
    protected $serieRepository;
    protected $tmdbService;
    protected $seasonService;

    public function __construct(SerieRepository $serieRepository, TMDBService $tmdbService, SeasonService $seasonService)
    {
        $this->serieRepository = $serieRepository;
        $this->tmdbService = $tmdbService;
        $this->seasonService = $seasonService;
    }

    public function importSeriesFromTMDB($totalPages = 10)
    {
        $series = $this->tmdbService->fetchAll($totalPages, 'tv');
        $importedCount = 0;
        $processedIds = [];

        foreach ($series as $serieData) {
            $tmdbId = $serieData['id'];
            if (!isset($processedIds[$tmdbId])) {
                $serie = $this->serieRepository->create([
                    'tmdb_id' => $tmdbId,
                    'name' => $serieData['name'],
                    'overview' => $serieData['overview'],
                    'first_air_date' => $serieData['first_air_date'],
                    'poster_path' => $serieData['poster_path'],
                ]);
                $processedIds[$tmdbId] = true;
                $this->seasonService->importSeason($serie);
                $importedCount++;
            }
        }

        return $importedCount;
    }

}
