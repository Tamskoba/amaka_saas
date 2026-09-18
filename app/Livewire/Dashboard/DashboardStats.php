<?php

namespace App\Livewire\Dashboard;

use App\Models\ResponseSet;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardStats extends Component
{
    public int $totalAssigned = 0;

    public int $completed = 0;

    public int $inProgress = 0;

    public int $remaining = 0;

    public function mount(): void
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Aucun utilisateur connecté
        |--------------------------------------------------------------------------
        */

        if (! $user) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Récupération ou création de la session active
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
        | Récupération des questionnaires assignés
        |--------------------------------------------------------------------------
        */

        $assignedForms = $user->forms()
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Initialisation des compteurs
        |--------------------------------------------------------------------------
        */

        $this->totalAssigned = $assignedForms->count();

        $this->completed = 0;
        $this->inProgress = 0;
        $this->remaining = 0;

        /*
        |--------------------------------------------------------------------------
        | Analyse de l'état de chaque questionnaire assigné
        |--------------------------------------------------------------------------
        */

        foreach ($assignedForms as $form) {
            $response = ResponseSet::where('user_id', $user->id)
                ->where('form_id', $form->id)
                ->where('session_id', $session->id)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Aucun ResponseSet = questionnaire pas commencé
            |--------------------------------------------------------------------------
            */

            if (! $response) {
                $this->remaining++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Comptage selon le statut de la réponse
            |--------------------------------------------------------------------------
            */

            switch ($response->status) {
                case 'completed':
                    $this->completed++;
                    break;

                case 'progress':
                case 'in_progress':
                    $this->inProgress++;
                    break;

                case 'new':
                case 'not_started':
                default:
                    $this->remaining++;
                    break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Debug temporaire
        |--------------------------------------------------------------------------
        */

        // dd([
        //     'user_id' => $user->id,
        //     'totalAssigned' => $this->totalAssigned,
        //     'completed' => $this->completed,
        //     'inProgress' => $this->inProgress,
        //     'remaining' => $this->remaining,
        // ]);
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-stats');
    }
}