<?php

namespace App\Http\Controllers;

use App\Models\ResponseSet;
use App\Services\AIAnalysisService;

class SynthesisController extends Controller
{
    public function generateAI(
        ResponseSet $responseSet,
        AIAnalysisService $ai
    ) {
        $ai->generate($responseSet);

        return back()->with(
            'success',
            'Analyse IA générée.'
        );
    }
}