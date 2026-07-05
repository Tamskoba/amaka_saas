<?php

namespace App\Http\Controllers;

use App\Models\ResponseSet;
use App\Services\ScoringService;

class ScoreController extends Controller
{
    public function generate(
        ResponseSet $responseSet,
        ScoringService $scoringService
    ) {
        $scoringService->generate(
            $responseSet
        );

        return back()->with(
            'success',
            'Scores générés.'
        );
    }
}