<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function importMovies(Request $request)
    {
        $importedCount = $this->movieService->importMoviesFromTMDB($request->totalPages ?? 10, $request->type ?? 'movie');

        return response()->json(['message' => "Imported $importedCount movies successfully"]);
    }
}
