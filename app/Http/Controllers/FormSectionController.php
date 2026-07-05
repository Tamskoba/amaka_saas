<?php

namespace App\Http\Controllers;

use App\Models\FormSection;
use Illuminate\Http\Request;

class FormSectionController extends Controller
{
    public function store(Request $request)
    {
        FormSection::create($request->all());

        return back()->with(
            'success',
            'Section créée.'
        );
    }

    public function update(
        Request $request,
        FormSection $formSection
    ) {
        $formSection->update($request->all());

        return back()->with(
            'success',
            'Section mise à jour.'
        );
    }

    public function destroy(FormSection $formSection)
    {
        $formSection->delete();

        return back()->with(
            'success',
            'Section supprimée.'
        );
    }
}