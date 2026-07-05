<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        Answer::updateOrCreate(
            [
                'response_set_id' =>
                    $request->response_set_id,

                'question_id' =>
                    $request->question_id
            ],
            [
                'answer_text' =>
                    $request->answer_text,

                'answer_value' =>
                    $request->answer_value
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }
}