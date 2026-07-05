<?php

namespace App\Http\Controllers;

use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuestionOptionController extends Controller
{
    public function store(Request $request)
    {
        QuestionOption::create($request->all());

        return back()->with(
            'success',
            'Option ajoutée.'
        );
    }

    public function destroy(
        QuestionOption $questionOption
    ) {
        $questionOption->delete();

        return back()->with(
            'success',
            'Option supprimée.'
        );
    }
}