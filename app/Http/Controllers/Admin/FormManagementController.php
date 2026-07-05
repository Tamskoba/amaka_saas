<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;

class FormManagementController extends Controller
{
    public function index()
    {
        $forms = Form::latest()
            ->paginate(20);

        return view(
            'admin.forms.index',
            compact('forms')
        );
    }
}