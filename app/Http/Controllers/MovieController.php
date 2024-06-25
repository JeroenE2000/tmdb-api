<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(protected MovieService $movieService){}

    public function importMovies(Request $request)
    {
        $importedCount = $this->movieService->importMoviesFromTMDB($request->totalPages ?? 10);

        return response()->json(['message' => "Imported $importedCount movies successfully"]);
    }
}
