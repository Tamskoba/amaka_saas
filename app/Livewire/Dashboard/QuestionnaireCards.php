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

    /**
     * Chargement des questionnaires assignés.
     */
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
        |
        | La session reste utilisée par le questionnaire lui-même.
        | En revanche, pour déterminer l'état d'un questionnaire dans
        | le tableau de bord, nous ne devons PAS limiter la recherche
        | du ResponseSet à cette session.
        |
        */

        UserSession::firstOrCreate(
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
        | Réinitialisation des compteurs
        |--------------------------------------------------------------------------
        */

        $this->totalAssigned = $assignedForms->count();
        $this->completed = 0;
        $this->inProgress = 0;
        $this->notStarted = 0;
        $this->forms = [];

        /*
        |--------------------------------------------------------------------------
        | Construction des cartes
        |--------------------------------------------------------------------------
        */

        foreach ($assignedForms as $form) {

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            |
            | On recherche le dernier ResponseSet de cet utilisateur
            | pour CE questionnaire, quelle que soit sa session.
            |
            | C'est volontairement identique à la logique utilisée
            | par QuestionnaireEngine::loadExistingResponses().
            |
            */

            $response = ResponseSet::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'form_id',
                    $form->id
                )
                ->latest('id')
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Détermination du statut
            |--------------------------------------------------------------------------
            */

            if (! $response) {

                /*
                | Aucun ResponseSet :
                | le questionnaire n'a jamais été commencé.
                */

                $status = 'not_started';

                $this->notStarted++;

            } else {

                $status = match ($response->status) {

                    /*
                    | Questionnaire terminé
                    */
                    'completed' => 'completed',

                    /*
                    | Questionnaire commencé mais non terminé
                    */
                    'progress',
                    'in_progress' => 'in_progress',

                    /*
                    | ResponseSet existant mais encore vierge
                    */
                    'new',
                    'not_started' => 'not_started',

                    /*
                    | Sécurité en cas de valeur inconnue
                    */
                    default => 'not_started',
                };

                /*
                |--------------------------------------------------------------------------
                | Mise à jour des compteurs
                |--------------------------------------------------------------------------
                */

                switch ($status) {

                    case 'completed':
                        $this->completed++;
                        break;

                    case 'in_progress':
                        $this->inProgress++;
                        break;

                    case 'not_started':
                        $this->notStarted++;
                        break;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Données de la carte
            |--------------------------------------------------------------------------
            */

            $this->forms[] = [

                'id' => $form->id,

                'title' => $form->title,

                'description' => $form->description,

                /*
                | Progression enregistrée.
                */
                'progress' => $response?->progress ?? 0,

                /*
                | Statut calculé.
                */
                'status' => $status,

                /*
                | Date de fin.
                */
                'completed_at' => $response?->completed_at,

                /*
                | Dernière modification.
                */
                'updated_at' => $response?->updated_at,
            ];
        }
    }

    /**
     * Consulter un questionnaire.
     *
     * Pour un questionnaire terminé, les réponses existantes
     * sont chargées par FormRunner.
     */
    public function viewForm(int $formId)
    {
        return redirect()->route(
            'forms.run',
            [
                'form' => $formId,
            ]
        );
    }

    /**
     * Modifier un questionnaire terminé.
     */
    public function editForm(int $formId)
    {
        return redirect()->route(
            'forms.run',
            [
                'form' => $formId,
                'edit' => 1,
            ]
        );
    }

    /**
     * Ouvrir un questionnaire non terminé.
     */
    public function openForm(int $formId)
    {
        return redirect()->route(
            'forms.run',
            [
                'form' => $formId,
            ]
        );
    }

    /**
     * Affichage.
     */
    public function render()
    {
        return view('livewire.dashboard.questionnaire-cards');
    }
}