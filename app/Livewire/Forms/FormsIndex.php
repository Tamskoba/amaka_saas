<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use App\Models\ResponseSet;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormsIndex extends Component
{
    public array $forms = [];

    public function mount(): void
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Aucun utilisateur connecté
        |--------------------------------------------------------------------------
        */

        if (! $user) {
            $this->forms = [];

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Session active
        |--------------------------------------------------------------------------
        */

        $session = UserSession::firstOrCreate(
            [
                'user_id' => $user->id,
                'status' => 'active',
            ],
            [
                'session_number' => 1,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Questionnaires assignés et visibles
        |--------------------------------------------------------------------------
        */

        $assignedForms = Form::whereHas(
            'users',
            function ($query) use ($user) {
                $query
                    ->where('user_id', $user->id)
                    ->where('is_visible', true);
            }
        )
        ->where('is_active', 1)
        ->where('is_deleted', 0)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | Construction de la liste avec le bon statut
        |--------------------------------------------------------------------------
        */

        $this->forms = $assignedForms
            ->map(function ($form) use ($user, $session) {

                /*
                |--------------------------------------------------------------------------
                | Réponse du questionnaire pour la session active
                |--------------------------------------------------------------------------
                */

                $response = ResponseSet::where('user_id', $user->id)
                    ->where('form_id', $form->id)
                    ->where('session_id', $session->id)
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | Détermination du statut normalisé
                |--------------------------------------------------------------------------
                */

                if (! $response) {
                    $status = 'not_started';
                } else {
                    $status = match ($response->status) {
                        'completed' => 'completed',

                        'progress',
                        'in_progress' => 'in_progress',

                        'new',
                        'not_started' => 'not_started',

                        default => 'not_started',
                    };
                }

                return [
                    'id' => $form->id,

                    'title' => $form->title,

                    'description' => $form->description,

                    'status' => $status,

                    'progress' => $response?->progress ?? 0,

                    'updated_at' => $response?->updated_at ?? $form->updated_at,
                ];
            })
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Debug temporaire
        |--------------------------------------------------------------------------
        */

        // dd($this->forms);
    }

    public function render()
    {
        return view('livewire.forms.forms-index');
    }

    public function openForm(int $formId)
    {
        return redirect()->route(
            'forms.run',
            $formId
        );
    }
}