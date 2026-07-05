<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Form;
use Livewire\Component;

class FormCreate extends Component
{
    public string $title = '';

    public string $description = '';

    public bool $is_active = true;

    public function save(): void
    {
        $this->validate([

            'title' => 'required|min:3',

            'description' => 'nullable',

        ]);

        Form::create([

            'title' => $this->title,

            'description' => $this->description,

            'is_active' => $this->is_active,

        ]);

        session()->flash(

            'success',

            'Questionnaire créé avec succès.'

        );

        $this->redirectRoute('admin.forms');
    }

    public function render()
    {
        return view(
            'livewire.admin.forms.form-create'
        )

        ->layout('components.layouts.admin');
    }
}