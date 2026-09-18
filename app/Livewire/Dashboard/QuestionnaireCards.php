<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\UserSession;
use App\Models\ResponseSet;

class QuestionnaireCards extends Component
{
    public array $forms = [];

    public int $totalAssigned = 0;

    public int $completed = 0;

    public int $inProgress = 0;

    public int $notStarted = 0;

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
            $this->totalAssigned = 0;
            $this->completed = 0;
            $this->inProgress = 0;
            $this->notStarted = 0;

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

        /*
        |--------------------------------------------------------------------------
        | Initialisation des statistiques
        |--------------------------------------------------------------------------
        */

        $this->totalAssigned = $assignedForms->count();
        $this->completed = 0;
        $this->inProgress = 0;
        $this->notStarted = 0;

        $this->forms = [];

        /*
        |--------------------------------------------------------------------------
        | Détermination de l'état de chaque questionnaire
        |--------------------------------------------------------------------------
        */

        foreach ($assignedForms as $form) {
            $response = ResponseSet::where('user_id', $user->id)
                ->where('form_id', $form->id)
                ->where('session_id', $session->id)
                ->first();

            /*
            |----------------------------------------------------------------------
            | Aucun enregistrement = questionnaire pas commencé
            |----------------------------------------------------------------------
            */

            if (! $response) {
                $status = 'not_started';
                $this->notStarted++;
            } else {
                /*
                |------------------------------------------------------------------
                | Normalisation du statut
                |------------------------------------------------------------------
                */

                $status = match ($response->status) {
                    'completed' => 'completed',
                    'progress', 'in_progress' => 'in_progress',
                    'new', 'not_started' => 'not_started',
                    default => 'not_started',
                };

                /*
                |------------------------------------------------------------------
                | Incrémentation des compteurs
                |------------------------------------------------------------------
                */

                match ($status) {
                    'completed' => $this->completed++,
                    'in_progress' => $this->inProgress++,
                    'not_started' => $this->notStarted++,
                };
            }

            /*
            |--------------------------------------------------------------------------
            | Données transmises à la vue
            |--------------------------------------------------------------------------
            */

            $this->forms[] = [
                'id' => $form->id,
                'title' => $form->title,
                'description' => $form->description,
                'progress' => $response?->progress ?? 0,
                'status' => $status,
                'completed_at' => $response?->completed_at,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Debug
        |--------------------------------------------------------------------------
        */

        // dd([
        //     'totalAssigned' => $this->totalAssigned,
        //     'completed' => $this->completed,
        //     'inProgress' => $this->inProgress,
        //     'notStarted' => $this->notStarted,
        //     'forms' => $this->forms,
        // ]);
    }

    public function render()
    {
        return view('livewire.dashboard.questionnaire-cards');
    }
}