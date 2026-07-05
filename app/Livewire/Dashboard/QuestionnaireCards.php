<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\UserSession;
use App\Models\ResponseSet;

class QuestionnaireCards extends Component
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
        | Questionnaires assignés
        |--------------------------------------------------------------------------
        */

        $assignedForms = $user->forms()
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        $this->forms = [];

        foreach ($assignedForms as $form) {

            $response = ResponseSet::where('user_id', $user->id)
                ->where('form_id', $form->id)
                ->where('session_id', $session->id)
                ->first();

            $this->forms[] = [

                'id' => $form->id,

                'title' => $form->title,

                'description' => $form->description,

                'progress' => $response?->progress ?? 0,

                'status' => $response?->status ?? 'not_started',

                'completed_at' => $response?->completed_at,

            ];
        }
    }

    public function render()
    {
        return view(
            'livewire.dashboard.questionnaire-cards'
        );
    }
}