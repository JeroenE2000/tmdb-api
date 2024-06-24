<?php

namespace App\Http\Controllers;

use App\Services\SerieService;
use Illuminate\Http\Request;

class Seriecontroller extends Controller
{
    protected $serieService;
    protected $seasonService;
    protected $episodeService;

    public function __construct(SerieService $serieService)
    {
        $this->serieService = $serieService;

    }

    public function importSeries(Request $request)
    {
        $importedCount = $this->serieService->importSeriesFromTMDB($request->totalPages ?? 10);

        return response()->json(['message' => "Imported $importedCount movies successfully"]);
    }
}
