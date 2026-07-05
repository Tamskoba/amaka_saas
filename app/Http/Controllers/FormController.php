<?php

namespace App\Http\Controllers;

use App\Models\Form;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::latest()->get();

        return view('forms.index', compact('forms'));
    }

    public function show(Form $form)
    {
        $form->load([
            'sections',
            'questions.options'
        ]);

        return view('forms.show', compact('form'));
    }
}