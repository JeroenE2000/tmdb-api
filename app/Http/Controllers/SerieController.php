<?php

namespace App\Http\Controllers;

use App\Services\SerieService;
use Illuminate\Http\Request;

class Seriecontroller extends Controller
{

    public function __construct(protected SerieService $serieService) {}

    public function importSeries(Request $request)
    {
        $importedCount = $this->serieService->importSeriesFromTMDB($request->totalPages ?? 10);

        return response()->json(['message' => "Imported $importedCount series successfully"]);
    }
}
