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
                | NORMALISATION DE CONDITIONAL_LOGIC
                |--------------------------------------------------------------------------
                |
                | La BDD peut contenir :
                |
                | conditional_logic = array
                |
                | ou :
                |
                | conditional_logic = JSON string
                |
                | On transforme toujours cela en depends_on utilisable
                | directement par FormRunner.
                |
                */

                if (
                    isset($question['conditional_logic'])
                    && ! empty($question['conditional_logic'])
                ) {

                    $conditionalLogic =
                        $question['conditional_logic'];

                    if (
                        is_string($conditionalLogic)
                        && $this->isJson($conditionalLogic)
                    ) {
                        $conditionalLogic =
                            json_decode(
                                $conditionalLogic,
                                true
                            );
                    }

                    if (
                        is_array($conditionalLogic)
                        && isset($conditionalLogic['question_key'])
                        && array_key_exists('value', $conditionalLogic)
                    ) {

                        $question['depends_on'] =
                            $conditionalLogic;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Si depends_on existe déjà, on le conserve.
                |--------------------------------------------------------------------------
                */

                if (
                    isset($question['depends_on'])
                    && is_string($question['depends_on'])
                    && $this->isJson($question['depends_on'])
                ) {

                    $question['depends_on'] =
                        json_decode(
                            $question['depends_on'],
                            true
                        );
                }

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
        $userId = Auth::id();

        if (! $userId) {
            return;
        }

        $this->responseSet = ResponseSet::where(
            'user_id',
            $userId
        )
            ->where(
                'form_id',
                $this->form->id
            )
            ->latest()
            ->first();

        if (! $this->responseSet) {
            return;
        }

        foreach ($this->responseSet->answers as $answer) {

            $value = $answer->answer_value;

            /*
            |--------------------------------------------------------------------------
            | JSON
            |--------------------------------------------------------------------------
            */

            if (
                is_string($value)
                && $this->isJson($value)
            ) {

                $decoded = json_decode(
                    $value,
                    true
                );

                /*
                |--------------------------------------------------------------------------
                | Réponse avec fréquence
                |--------------------------------------------------------------------------
                */

                if (
                    is_array($decoded)
                    && array_key_exists('value', $decoded)
                    && array_key_exists('frequency', $decoded)
                ) {

                    $this->answers[
                        $answer->question_id
                    ] = $decoded['value'];

                    $this->frequencies[
                        $answer->question_id
                    ] = $decoded['frequency'];

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Checkbox ou autre réponse JSON
                |--------------------------------------------------------------------------
                */

                $this->answers[
                    $answer->question_id
                ] = $decoded;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Réponse simple
            |--------------------------------------------------------------------------
            */

            $this->answers[
                $answer->question_id
            ] = $value;
        }

        /*
        |--------------------------------------------------------------------------
        | Initialisation des checkbox
        |--------------------------------------------------------------------------
        */

        foreach ($this->questions as $question) {

            if (
                ($question['question_type'] ?? null) === 'checkbox'
                && ! array_key_exists(
                    $question['id'],
                    $this->answers
                )
            ) {

                $this->answers[
                    $question['id']
                ] = [];
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