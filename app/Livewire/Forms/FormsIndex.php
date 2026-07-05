<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormsIndex extends Component
{
    public $forms = [];

    public function mount(): void
    {
        $this->forms = Form::whereHas(

            'users',

            function ($query) {

                $query

                    ->where('user_id', Auth::id())

                    ->where('is_visible', true);

            }

        )

        ->with(['responseSets' => function ($query) {

            $query->where(

                'user_id',

                Auth::id()

            );

        }])

        ->get()

        ->map(function ($form) {

            $response = $form

                ->responseSets

                ->first();

            return [

                'id' => $form->id,

                'title' => $form->title,

                'description' => $form->description,

                'status' => $response->status ?? 'not_started',

                'progress' => $response->progress ?? 0,

                'updated_at' => $response->updated_at ?? now(),

            ];

        });
    }

    public function render()
    {
        return view(
            'livewire.forms.forms-index'
        );
    }

    public function openForm(int $formId)
    {
        return redirect()->route(
            'forms.run',
            $formId
        );
    }   
}