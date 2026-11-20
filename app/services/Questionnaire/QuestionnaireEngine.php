<?php

namespace App\Services\Questionnaire;

use App\Models\Form;
use App\Models\ResponseSet;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class QuestionnaireEngine
{
    protected Form $form;

    protected ?UserSession $session = null;

    protected ?ResponseSet $responseSet = null;

    protected array $sections = [];

    protected array $questions = [];

    protected array $answers = [];

    protected array $frequencies = [];

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function load(): self
    {
        $this->loadSession();

        $this->loadQuestions();

        $this->loadExistingResponses();

        return $this;
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    public function getSession(): ?UserSession
    {
        return $this->session;
    }

    public function getSections(): array
    {
        return $this->sections;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function getFrequencies(): array
    {
        return $this->frequencies;
    }

    public function getResponseSet(): ?ResponseSet
    {
        return $this->responseSet;
    }

    public function isCompleted(): bool
    {
        return $this->responseSet?->status === 'completed';
    }

    /*
    |--------------------------------------------------------------------------
    | SESSION
    |--------------------------------------------------------------------------
    */

    protected function loadSession(): void
    {
        $userId = Auth::id();

        if (! $userId) {
            $this->session = null;
            return;
        }

        $this->session = UserSession::where('user_id', $userId)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $this->session) {
            $lastSessionNumber = UserSession::where(
                'user_id',
                $userId
            )->max('session_number');

            $this->session = UserSession::create([
                'user_id' => $userId,
                'session_number' => ($lastSessionNumber ?? 0) + 1,
                'status' => 'active',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | QUESTIONS
    |--------------------------------------------------------------------------
    */

    protected function loadQuestions(): void
    {
        $this->sections = $this->form
            ->sections()
            ->with([
                'questions.options',
            ])
            ->orderBy('sort_order')
            ->get()
            ->toArray();

        $this->questions = [];

        foreach ($this->sections as $section) {

            foreach ($section['questions'] as $question) {

                /*
                |--------------------------------------------------------------------------
                | NORMALISATION DE LA LOGIQUE CONDITIONNELLE
                |--------------------------------------------------------------------------
                */

                $conditionalLogic = $question['conditional_logic'] ?? null;

                // Décoder le JSON si nécessaire.
                if (is_string($conditionalLogic) && $this->isJson($conditionalLogic)) {
                    $conditionalLogic = json_decode($conditionalLogic, true);
                }

                // Uniformiser la structure pour FormRunner.
                if (
                    is_array($conditionalLogic)
                    && isset($conditionalLogic['question_key'])
                    && array_key_exists('value', $conditionalLogic)
                ) {
                    $question['depends_on'] = $conditionalLogic;
                } elseif (
                    is_array($question['depends_on'] ?? null)
                ) {
                    // Conserver un depends_on déjà présent dans les données.
                } elseif (
                    is_string($question['depends_on'] ?? null)
                    && $this->isJson($question['depends_on'])
                ) {
                    $question['depends_on'] = json_decode(
                        $question['depends_on'],
                        true
                    );
                } else {
                    $question['depends_on'] = null;
                }

                /*
                |--------------------------------------------------------------------------
                | NORMALISATION DE LA FRÉQUENCE
                |--------------------------------------------------------------------------
                */

                $question['has_frequency'] = (bool) ($question['has_frequency'] ?? false);

                /*
                |--------------------------------------------------------------------------
                | CONSERVATION DE LA QUESTION
                |--------------------------------------------------------------------------
                */

                $this->questions[] = $question;

            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EXISTING RESPONSES
    |--------------------------------------------------------------------------
    */

    protected function loadExistingResponses(): void
    {
        if (! Auth::check()) {
            return;
        }

        $responseSet = ResponseSet::where('user_id', Auth::id())
            ->where('form_id', $this->form->id)
            ->when(
                $this->session,
                fn ($query) => $query->where('session_id', $this->session->id)
            )
            ->latest('id')
            ->first();

        if (! $responseSet) {
            $this->responseSet = null;

            // Initialiser les checkbox sans réponse.
            foreach ($this->questions as $question) {
                if (($question['question_type'] ?? null) === 'checkbox') {
                    $this->answers[$question['id']] = [];
                }
            }

            return;
        }

        $this->responseSet = $responseSet;

        foreach ($responseSet->answers as $answerRecord) {
            $questionId = $answerRecord->question_id;

            // Priorité à answer_text, qui peut contenir le JSON complet.
            $rawValue = $answerRecord->answer_text;

            if ($rawValue === null || $rawValue === '') {
                $rawValue = $answerRecord->answer_value;
            }

            if ($rawValue === null || $rawValue === '') {
                continue;
            }

            $decoded = json_decode($rawValue, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // Format des questions avec fréquence :
                // {"value": ..., "frequency": ...}
                if (
                    array_key_exists('value', $decoded)
                    && array_key_exists('frequency', $decoded)
                ) {
                    $this->answers[$questionId] = $decoded['value'];
                    $this->frequencies[$questionId] = $decoded['frequency'];
                } else {
                    // Format des réponses de type checkbox ou tableau.
                    $this->answers[$questionId] = $decoded;
                }
            } else {
                // Réponse simple : texte, radio, date, nombre, etc.
                $this->answers[$questionId] = $rawValue;
            }
        }

        // Initialiser les checkbox qui n'ont aucune réponse enregistrée.
        foreach ($this->questions as $question) {
            $questionId = $question['id'];

            if (
                ($question['question_type'] ?? null) === 'checkbox'
                && ! array_key_exists($questionId, $this->answers)
            ) {
                $this->answers[$questionId] = [];
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | JSON
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
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function getTotalQuestions(): int
    {
        return count($this->questions);
    }

    public function hasQuestions(): bool
    {
        return count($this->questions) > 0;
    }

    public function getQuestion(int $index): ?array
    {
        return $this->questions[$index] ?? null;
    }

    public function calculateProgress(int $currentIndex): int
    {
        $total = count($this->questions);

        if ($total === 0) {
            return 0;
        }

        return (int) round(
            (($currentIndex + 1) / $total) * 100
        );
    }
}