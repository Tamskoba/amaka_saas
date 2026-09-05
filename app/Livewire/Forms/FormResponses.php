<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use App\Models\ResponseSet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormResponses extends Component
{
    public Form $form;

    public ?ResponseSet $responseSet = null;

    public array $answers = [];

    public function mount(Form $form): void
    {
        $this->form = $form;

        /*
        |--------------------------------------------------------------------------
        | Récupération de la dernière réponse terminée
        |--------------------------------------------------------------------------
        */

        $this->responseSet = ResponseSet::with([
            'answers.question.options'
        ])
        ->where('user_id', Auth::id())
        ->where('form_id', $this->form->id)
        ->where('status', 'completed')
        ->latest()
        ->first();

        /*
        |--------------------------------------------------------------------------
        | Aucune réponse
        |--------------------------------------------------------------------------
        */

        if (! $this->responseSet) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Transformation des réponses
        |--------------------------------------------------------------------------
        */

        foreach ($this->responseSet->answers as $answer) {

            $value = $answer->answer_value;

            if (
                is_string($value)
                &&
                $this->isJson($value)
            ) {

                $value = json_decode(
                    $value,
                    true
                );
            }

            $this->answers[
                $answer->question_id
            ] = $value;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Vérifie si une valeur est du JSON
    |--------------------------------------------------------------------------
    */

    protected function isJson(mixed $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        json_decode($value);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /*
    |--------------------------------------------------------------------------
    | Affichage
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.forms.form-responses'
        );
    }
}