<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        Question::create($request->all());

        return back()->with(
            'success',
            'Question ajoutée.'
        );
    }

    public function update(
        Request $request,
        Question $question
    ) {
        $question->update($request->all());

        return back()->with(
            'success',
            'Question mise à jour.'
        );
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with(
            'success',
            'Question supprimée.'
        );
    }
}