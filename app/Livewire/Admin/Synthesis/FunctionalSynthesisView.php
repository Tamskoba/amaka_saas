<?php

namespace App\Livewire\Admin\Synthesis;

use App\Models\Answer;
use App\Models\FunctionalSynthesis;
use App\Models\ResponseSet;
use App\Models\User;
use App\Models\UserSession;
use App\Services\Synthesis\FunctionalSynthesisGenerator;
use App\Services\Synthesis\DetailedSynthesisBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class FunctionalSynthesisView extends Component
{
    public ?int $selectedUserId = null;

    public ?int $selectedSessionId = null;

    public string $presentationMode = 'questionnaire';

    public ?FunctionalSynthesis $synthesis = null;

    public array $synthesisData = [];

    public array $detailedSynthesis = [];

    public bool $showDetailedMetadata = true;

    public function mount(User $user): void
    {
        Gate::authorize('functional-synthesis.viewAny');

        Gate::authorize('functional-synthesis.view', $user);

        $this->selectedUserId = $user->id;

        // Priorité à la session active.
        $session = UserSession::query()
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->orderByDesc('session_number')
            ->orderByDesc('id')
            ->first();

        // S'il n'existe pas de session active,
        // prendre la session la plus récente.
        if (!$session) {
            $session = UserSession::query()
                ->where('user_id', $user->id)
                ->orderByDesc('session_number')
                ->orderByDesc('id')
                ->first();
        }

        if ($session) {
            $this->selectedSessionId = $session->id;

            $this->loadSynthesisData();
        }
    }

    /**
     * Liste des utilisateurs accessibles selon les autorisations.
     */
    public function getAvailableUsersProperty(): Collection
    {
        return User::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('is_deleted', false)
                    ->orWhereNull('is_deleted');
            })
            ->whereIn('role', [
                'admin',
                'micronutritionniste',
                'client',
            ])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->filter(function (User $user) {
                return Gate::allows(
                    'functional-synthesis.view',
                    $user
                );
            })
            ->values();
    }

 
    /**
     * Quand la session change, charger les données correspondantes.
     */
    public function updatedSelectedSessionId(): void
    {
        $this->synthesis = null;
        $this->synthesisData = [];
        $this->detailedSynthesis = [];

        if ($this->selectedSessionId) {
            $this->loadSynthesisData();
        }
    }

    /**
     * Change le mode de présentation sans régénérer la synthèse.
     */
    public function updatedPresentationMode(): void
    {
        if (!in_array($this->presentationMode, [
            'questionnaire',
            'theme',
            'detailed',
        ], true)) {
            $this->presentationMode = 'questionnaire';
        }
    }

    /**
     * Génère ou actualise la synthèse brute,
     * puis recharge les données.
     */
    public function generate(
        FunctionalSynthesisGenerator $generator
    ): void {
        $user = $this->getSelectedUser();

        Gate::authorize('functional-synthesis.generate', $user);

        $session = $this->getSelectedSession($user);

        $this->synthesis = $generator->generate(
            $user,
            $session
        );

        $this->loadSynthesisData();

        session()->flash(
            'success',
            'La synthèse fonctionnelle a été actualisée.'
        );
    }

    /**
     * Recharge les questionnaires et leurs réponses pour la session.
     */
    private function loadSynthesisData(): void
    {
        $user = $this->getSelectedUser();

        Gate::authorize('functional-synthesis.view', $user);

        $session = $this->getSelectedSession($user);

        $this->synthesis = FunctionalSynthesis::query()
            ->where('user_id', $user->id)
            ->where('session_id', $session->id)
            ->first();

        $responseSets = ResponseSet::query()
            ->where('user_id', $user->id)
            ->where('session_id', $session->id)
            ->with([
                'form.sections.questions.options',
                'answers.question.options',
                'answers.question.section',
            ])
            ->orderBy('form_id')
            ->orderBy('id')
            ->get();

        // Modes de présentation existants.
        $this->synthesisData = $this->buildPresentationData(
            $responseSets
        );

        // Nouveau mode : synthèse fonctionnelle détaillée.
        $this->detailedSynthesis = app(
            DetailedSynthesisBuilder::class
        )->build($responseSets);
    }

    /**
     * Construit les deux regroupements à partir des mêmes réponses.
     */
    private function buildPresentationData(
        Collection $responseSets
    ): array {
        $questionnaires = [];
        $themes = [];

        foreach ($responseSets as $responseSet) {
            $form = $responseSet->form;

            $questionnaire = [
                'title' => $form?->title ?? 'Questionnaire sans titre',
                'status' => $this->formatStatus($responseSet->status),
                'progress' => (int) ($responseSet->progress ?? 0),
                'sections' => [],
            ];

            foreach ($responseSet->answers as $answer) {
                $question = $answer->question;

                $questionText = $question?->question_text
                    ?? 'Question introuvable (ID : '
                    . $answer->question_id
                    . ')';

                $sectionTitle = $question?->section?->title
                    ?? 'Section non renseignée';

                $answerText = $this->formatAnswer(
                    $answer,
                    $question
                );

                // Présentation par questionnaire.
                $questionnaire['sections'][$sectionTitle][] = [
                    'question' => $questionText,
                    'answer' => $answerText,
                ];

                // Présentation par grand thème.
                $themeName = trim(
                    (string) ($question?->scoring_group ?? '')
                );

                if ($themeName === '') {
                    $themeName = 'Thème fonctionnel non défini';
                }

                $themes[$themeName][] = [
                    'question' => $questionText,
                    'answer' => $answerText,
                    'questionnaire' => $form?->title
                        ?? 'Questionnaire sans titre',
                    'section' => $sectionTitle,
                    'status' => $this->formatStatus(
                        $responseSet->status
                    ),
                ];
            }

            $questionnaires[] = $questionnaire;
        }

        ksort($themes, SORT_NATURAL | SORT_FLAG_CASE);

        return [
            'questionnaires' => $questionnaires,
            'themes' => $themes,
        ];
    }

    /**
     * Formate la réponse et remplace les valeurs d'options
     * par leurs libellés.
     */
    private function formatAnswer(
        Answer $answer,
        $question
    ): string {
        $raw = $answer->answer_text;

        if ($raw === null || $raw === '') {
            $raw = $answer->answer_value;
        }

        if ($raw === null || $raw === '') {
            return 'Réponse enregistrée sans contenu exploitable.';
        }

        $decoded = $raw;

        if (is_string($raw)) {
            $candidate = json_decode($raw, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $decoded = $candidate;
            }
        }

        if (
            is_array($decoded)
            && array_key_exists('value', $decoded)
        ) {
            $value = $this->formatValue(
                $decoded['value'],
                $question
            );

            $frequency = $decoded['frequency'] ?? null;

            if (is_array($frequency)) {
                $frequencyParts = [];

                foreach (
                    $frequency as $optionValue => $frequencyValue
                ) {
                    if (
                        $frequencyValue === null
                        || $frequencyValue === ''
                    ) {
                        continue;
                    }

                    $frequencyParts[] = $this->optionLabel(
                        $question,
                        (string) $optionValue
                    ) . ' : ' . $frequencyValue;
                }

                $frequency = implode('; ', $frequencyParts);
            }

            return $value . (
                is_string($frequency) && trim($frequency) !== ''
                    ? ' — Fréquence : ' . $frequency
                    : ''
            );
        }

        return $this->formatValue($decoded, $question);
    }

    /**
     * Formate une valeur simple ou multiple.
     */
    private function formatValue(
        mixed $value,
        $question
    ): string {
        if ($value === null || $value === '') {
            return 'Valeur vide';
        }

        if (is_bool($value)) {
            return $value ? 'Oui' : 'Non';
        }

        if (is_array($value)) {
            $values = [];

            foreach ($value as $key => $item) {
                if (is_array($item)) {
                    $values[] = $this->formatValue(
                        $item,
                        $question
                    );
                } elseif (is_string($key)) {
                    $values[] = $this->optionLabel(
                        $question,
                        $key
                    ) . ' : ' . $item;
                } else {
                    $values[] = $this->optionLabel(
                        $question,
                        (string) $item
                    );
                }
            }

            return $values === []
                ? 'Aucune option sélectionnée'
                : implode(', ', $values);
        }

        return $this->optionLabel(
            $question,
            trim((string) $value)
        );
    }

    /**
     * Récupère le libellé d'une option.
     */
    private function optionLabel(
        $question,
        string $value
    ): string {
        if ($question) {
            foreach ($question->options as $option) {
                if (
                    (string) $option->option_value === $value
                ) {
                    return (string) $option->option_label;
                }
            }
        }

        return $value;
    }

    /**
     * Traduit le statut d'un questionnaire.
     */
    private function formatStatus(?string $status): string
    {
        return match ($status) {
            'completed' => 'Terminé',
            'progress' => 'En cours',
            'new' => 'Nouveau',
            'not_started' => 'Non commencé',
            default => $status ?: 'Inconnu',
        };
    }

    /**
     * Récupère l'utilisateur sélectionné.
     *
     * L'autorisation est vérifiée à chaque accès.
     */
    private function getSelectedUser(): User
    {
        abort_unless(
            $this->selectedUserId,
            422,
            'Sélectionne un utilisateur.'
        );

        $user = User::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('is_deleted', false)
                    ->orWhereNull('is_deleted');
            })
            ->whereIn('role', [
                'admin',
                'micronutritionniste',
                'client',
            ])
            ->findOrFail($this->selectedUserId);

        Gate::authorize('functional-synthesis.view', $user);

        return $user;
    }

    /**
     * Récupère la session sélectionnée.
     *
     * Vérifie impérativement que la session appartient
     * à l'utilisateur sélectionné.
     */
    private function getSelectedSession(User $user): UserSession
    {
        abort_unless(
            $this->selectedSessionId,
            422,
            'Sélectionne une session.'
        );

        return UserSession::query()
            ->where('user_id', $user->id)
            ->findOrFail($this->selectedSessionId);
    }

    /**
     * Exporte la synthèse fonctionnelle détaillée au format PDF.
     */
    public function exportDetailedPdf()
    {
        // L'export est réservé au mode détaillé.
        abort_unless(
            $this->presentationMode === 'detailed',
            403,
            'L’export PDF est disponible uniquement en mode détaillé.'
        );

        // Vérification de l'utilisateur et de ses autorisations.
        $user = $this->getSelectedUser();

        Gate::authorize('functional-synthesis.view', $user);

        // Vérification que la session appartient bien à cet utilisateur.
        $session = $this->getSelectedSession($user);

        // Recharger les questionnaires et les réponses de la session.
        $responseSets = ResponseSet::query()
            ->where('user_id', $user->id)
            ->where('session_id', $session->id)
            ->with([
                'form.sections.questions.options',
                'answers.question.options',
                'answers.question.section',
            ])
            ->orderBy('form_id')
            ->orderBy('id')
            ->get();

        // Reconstruire la synthèse à partir des données actuelles.
        $detailedSynthesis = app(
            DetailedSynthesisBuilder::class
        )->build($responseSets);

        // Respecter l'état de la checkbox de traçabilité.
        $showDetailedMetadata = $this->showDetailedMetadata;

        $pdf = Pdf::loadView(
            'pdf.synthesis.detailed',
            [
                'user' => $user,
                'session' => $session,
                'synthesis' => $detailedSynthesis,
                'showMetadata' => $showDetailedMetadata,
                'exportedAt' => now(),
            ]
        )->setPaper('a4', 'portrait');

        $filename = 'synthese-detaillee-session-'
            . $session->session_number
            . '-' . $user->id
            . '.pdf';

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            $filename,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }    

    /**
     * Affichage de la page.
     */
    public function render()
    {
        $selectedUser = $this->getSelectedUser();

        $canGenerate = Gate::allows(
            'functional-synthesis.generate',
            $selectedUser
        );

        $sessions = UserSession::query()
            ->where('user_id', $selectedUser->id)
            ->orderByDesc('session_number')
            ->orderByDesc('id')
            ->get();

        return view(
            'livewire.admin.synthesis.functional-synthesis-view',
            [
                'selectedUser' => $selectedUser,
                'sessions' => $sessions,
                'canGenerate' => $canGenerate,
            ]
        )->layout('components.layouts.admin');
    }
}