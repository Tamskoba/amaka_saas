<?php

namespace App\Http\Controllers;

use App\Models\UserForm;

class UserFormController extends Controller
{
    public function index()
    {
        $forms = UserForm::with([
            'form',
            'user'
        ])->latest()->get();

        return view(
            'user_forms.index',
            compact('forms')
        );
    }
}