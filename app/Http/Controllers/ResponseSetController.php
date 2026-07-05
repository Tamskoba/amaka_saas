<?php

namespace App\Http\Controllers;

use App\Models\ResponseSet;

class ResponseSetController extends Controller
{
    public function show(ResponseSet $responseSet)
    {
        $responseSet->load([
            'answers.question',
            'scores',
            'synthesis'
        ]);

        return view(
            'responses.show',
            compact('responseSet')
        );
    }
}