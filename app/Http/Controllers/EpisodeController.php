<?php

namespace App\Http\Controllers;

use App\Services\EpisodeService;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{

    public function __construct(protected EpisodeService $episodeService){}

    public function importEpisodes(Request $request)
    {
        $importedCount = $this->episodeService->importEpisodesForSeries($request->serie_id ?? 1);
        if($importedCount === 0) {
            return response()->json(['message' => "No new episodes to import for this series are you sure the series exists?"]);
        }
        return response()->json(['message' => "Imported $importedCount episodes successfully"]);
    }
}
