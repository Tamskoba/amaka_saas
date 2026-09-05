<?php

namespace App\Livewire\Forms;

use App\Models\Answer;
use App\Models\Form;
use App\Models\ResponseSet;
use App\Models\UserSession;
use App\Services\Questionnaire\QuestionnaireEngine;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormRunner extends Component
{
    public Form $form;

    public array $sections = [];

    public array $questions = [];

    public array $answers = [];

    public array $frequencies = [];

    public int $currentQuestionIndex = 0;

    public ?array $currentQuestion = null;

    public ?UserSession $session = null;

    public bool $isCompleted = false;

    public bool $isEditMode = false;

    public bool $isEditing = false;

    protected QuestionnaireEngine $engine;

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount(Form $form): void
    {
        $this->form = $form;

        $this->isEditMode = request()->boolean('edit');

        $this->isEditing = $this->isEditMode;

        $this->engine = new QuestionnaireEngine($this->form);

        $this->engine->load();

        $this->sections =
            $this->engine->getSections();

        $this->questions =
            $this->engine->getQuestions();

        $this->answers =
            $this->engine->getAnswers();

        $this->frequencies =
            $this->engine->getFrequencies();

        $this->session =
            $this->engine->getSession();

        $this->isCompleted =
            $this->engine->isCompleted();

        /*
        |--------------------------------------------------------------------------
        | Aucun questionnaire
        |--------------------------------------------------------------------------
        */

        if (empty($this->questions)) {
            $this->currentQuestion = null;
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Questionnaire terminé
        |--------------------------------------------------------------------------
        */

        if (
            $this->isCompleted
            && ! $this->isEditMode
        ) {

            $this->currentQuestion = null;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Recherche première question visible
        |--------------------------------------------------------------------------
        */

        $this->currentQuestion = null;

        foreach ($this->questions as $index => $question) {

            if (
                $this->shouldShowQuestion($question)
            ) {

                $this->currentQuestionIndex =
                    $index;

                $this->currentQuestion =
                    $question;

                break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | En mode normal, chercher première question visible non répondue
        |--------------------------------------------------------------------------
        */

        if (! $this->isEditMode) {

            foreach (
                $this->questions as $index => $question
            ) {

                if (
                    ! $this->shouldShowQuestion(
                        $question
                    )
                ) {
                    continue;
                }

                if (
                    ! array_key_exists(
                        $question['id'],
                        $this->answers
                    )
                ) {

                    $this->currentQuestionIndex =
                        $index;

                    $this->currentQuestion =
                        $question;

                    break;
                }
            }
        }

        $this->initializeCheckboxAnswer(
            $this->currentQuestion
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PREVIOUS
    |--------------------------------------------------------------------------
    */

    public function previousQuestion(): void
    {
        if ($this->currentQuestionIndex <= 0) {
            return;
        }

        $index =
            $this->currentQuestionIndex - 1;

        while ($index >= 0) {

            $question =
                $this->questions[$index] ?? null;

            if (
                $question
                && $this->shouldShowQuestion($question)
            ) {

                $this->currentQuestionIndex =
                    $index;

                $this->currentQuestion =
                    $question;

                $this->initializeCheckboxAnswer(
                    $question
                );

                $this->resetErrorBag();

                return;
            }

            $index--;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | NEXT
    |--------------------------------------------------------------------------
    */

    public function nextQuestion(): void
    {
        if (! $this->currentQuestion) {
            return;
        }

        if (! $this->validateCurrentQuestion()) {
            return;
        }

        $this->resetErrorBag();

        $nextIndex =
            $this->currentQuestionIndex + 1;

        while (
            $nextIndex < count($this->questions)
        ) {

            $nextQuestion =
                $this->questions[$nextIndex];

            /*
            |--------------------------------------------------------------------------
            | Question cachée
            |--------------------------------------------------------------------------
            */

            if (
                ! $this->shouldShowQuestion(
                    $nextQuestion
                )
            ) {

                $this->removeHiddenQuestionAnswer(
                    $nextQuestion
                );

                $nextIndex++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Question visible
            |--------------------------------------------------------------------------
            */

            $this->currentQuestionIndex =
                $nextIndex;

            $this->currentQuestion =
                $nextQuestion;

            $this->initializeCheckboxAnswer(
                $nextQuestion
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Fin
        |--------------------------------------------------------------------------
        */

        $this->saveResponses();
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    protected function validateCurrentQuestion(): bool
    {
        $question =
            $this->currentQuestion;

        if (! $question) {
            return true;
        }

        $questionId =
            $question['id'];

        $answer =
            $this->answers[$questionId] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Question conditionnelle cachée
        |--------------------------------------------------------------------------
        */

        if (
            $this->isConditionalQuestion($question)
            && ! $this->shouldShowQuestion($question)
        ) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Question obligatoire
        |--------------------------------------------------------------------------
        */

        if (
            ($question['is_required'] ?? false)
            && $this->isEmptyAnswer($answer)
        ) {

            $this->addError(
                'answer',
                'Cette question est obligatoire.'
            );

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Fréquence
        |--------------------------------------------------------------------------
        */

        if (
            $this->isTemporalQuestion($question)
            && ! $this->isEmptyAnswer($answer)
            && empty(
                $this->frequencies[$questionId] ?? null
            )
        ) {

            $this->addError(
                'frequency',
                'Veuillez préciser la fréquence.'
            );

            return false;
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | TEMPORAL
    |--------------------------------------------------------------------------
    */

    public function isTemporalQuestion(
        array $question
    ): bool {

        return
            ($question['has_frequency'] ?? false)
            === true;
    }

    /*
    |--------------------------------------------------------------------------
    | CONDITIONAL
    |--------------------------------------------------------------------------
    */

    public function isConditionalQuestion(
        array $question
    ): bool {

        return
            isset($question['depends_on'])
            && is_array($question['depends_on'])
            && isset($question['depends_on']['question_key'])
            && array_key_exists(
                'value',
                $question['depends_on']
            );
    }

    public function shouldShowQuestion(
        array $question
    ): bool {

        if (
            ! $this->isConditionalQuestion(
                $question
            )
        ) {
            return true;
        }

        $dependency =
            $question['depends_on'];

        $parentQuestionKey =
            $dependency['question_key']
            ?? null;

        $requiredValue =
            $dependency['value']
            ?? null;

        if (
            ! $parentQuestionKey
            || $requiredValue === null
        ) {
            return true;
        }

        $parentQuestion =
            collect($this->questions)
                ->first(
                    fn ($q) =>
                        ($q['question_key'] ?? null)
                        === $parentQuestionKey
                        ||
                        ($q['question_text'] ?? null)
                        === $parentQuestionKey
                );

        if (! $parentQuestion) {
            return false;
        }

        $parentId =
            $parentQuestion['id'];

        $parentAnswer =
            $this->answers[$parentId]
            ?? null;

        if (is_array($parentAnswer)) {

            return in_array(
                (string) $requiredValue,
                array_map(
                    'strval',
                    $parentAnswer
                ),
                true
            );
        }

        return
            (string) $parentAnswer
            ===
            (string) $requiredValue;
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE HIDDEN
    |--------------------------------------------------------------------------
    */

    protected function removeHiddenQuestionAnswer(
        array $question
    ): void {

        if (
            ! $this->isConditionalQuestion(
                $question
            )
        ) {
            return;
        }

        if (
            ! $this->shouldShowQuestion(
                $question
            )
        ) {

            unset(
                $this->answers[
                    $question['id']
                ]
            );

            unset(
                $this->frequencies[
                    $question['id']
                ]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EMPTY ANSWER
    |--------------------------------------------------------------------------
    */

    protected function isEmptyAnswer(
        mixed $answer
    ): bool {

        if ($answer === null) {
            return true;
        }

        if (
            is_string($answer)
            && trim($answer) === ''
        ) {
            return true;
        }

        if (
            is_array($answer)
            && count($answer) === 0
        ) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKBOX
    |--------------------------------------------------------------------------
    */

    protected function initializeCheckboxAnswer(
        ?array $question
    ): void {

        if (! $question) {
            return;
        }

        if (
            ($question['question_type'] ?? null)
            === 'checkbox'
            &&
            ! array_key_exists(
                $question['id'],
                $this->answers
            )
        ) {

            $this->answers[
                $question['id']
            ] = [];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATED ANSWERS
    |--------------------------------------------------------------------------
    */

    public function updatedAnswers(
        $value,
        $key
    ): void {

        $this->resetErrorBag();

        /*
        |--------------------------------------------------------------------------
        | Suppression des réponses des questions devenues invisibles
        |--------------------------------------------------------------------------
        */

        foreach ($this->questions as $question) {

            if (
                ! $this->isConditionalQuestion(
                    $question
                )
            ) {
                continue;
            }

            if (
                ! $this->shouldShowQuestion(
                    $question
                )
            ) {

                $this->removeHiddenQuestionAnswer(
                    $question
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    */

    public function saveResponses(): void
    {
        if (! $this->session) {
            return;
        }

        $responseSet =
            ResponseSet::updateOrCreate(
                [
                    'user_id' =>
                        Auth::id(),

                    'form_id' =>
                        $this->form->id,

                    'session_id' =>
                        $this->session->id,
                ],
                [
                    'status' =>
                        'completed',

                    'progress' =>
                        100,

                    'completed_at' =>
                        now(),
                ]
            );

        /*
        |--------------------------------------------------------------------------
        | Supprimer les anciennes réponses
        |--------------------------------------------------------------------------
        */

        Answer::where(
            'response_set_id',
            $responseSet->id
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | Sauvegarder toutes les réponses
        |--------------------------------------------------------------------------
        */

        foreach ($this->questions as $question) {

            $questionId =
                $question['id'];

            /*
            |--------------------------------------------------------------------------
            | Question conditionnelle cachée
            |--------------------------------------------------------------------------
            */

            if (
                ! $this->shouldShowQuestion(
                    $question
                )
            ) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Une question sans réponse n'a rien à enregistrer
            |--------------------------------------------------------------------------
            */

            if (
                ! array_key_exists(
                    $questionId,
                    $this->answers
                )
            ) {
                continue;
            }

            $answer =
                $this->answers[$questionId];

            /*
            |--------------------------------------------------------------------------
            | Fréquence
            |--------------------------------------------------------------------------
            */

            if (
                $this->isTemporalQuestion(
                    $question
                )
            ) {

                $storedValue = [
                    'value' =>
                        $answer,

                    'frequency' =>
                        $this->frequencies[
                            $questionId
                        ]
                        ?? 'jamais',
                ];

                $answerText =
                    json_encode(
                        $storedValue,
                        JSON_UNESCAPED_UNICODE
                    );

            } else {

                $answerText =
                    is_array($answer)
                    ? json_encode(
                        $answer,
                        JSON_UNESCAPED_UNICODE
                    )
                    : (string) $answer;
            }

            Answer::create([
                'response_set_id' =>
                    $responseSet->id,

                'question_id' =>
                    $questionId,

                'answer_text' =>
                    $answerText,

                'answer_value' =>
                    $answerText,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Statut
        |--------------------------------------------------------------------------
        */

        $this->isCompleted = true;

        $assignedFormsCount =
            auth()
                ->user()
                ->forms()
                ->count();

        $completedFormsCount =
            ResponseSet::where(
                'session_id',
                $this->session->id
            )
            ->where(
                'status',
                'completed'
            )
            ->distinct('form_id')
            ->count();

        if (
            $assignedFormsCount > 0
            &&
            $completedFormsCount >=
                $assignedFormsCount
        ) {

            $this->session->update([
                'status' =>
                    'completed',

                'completed_at' =>
                    now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sortie du mode édition
        |--------------------------------------------------------------------------
        */

        $this->isEditMode = false;

        $this->isEditing = false;

        $this->currentQuestion = null;
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRESS
    |--------------------------------------------------------------------------
    */

    public function getProgressProperty(): int
    {
        if (
            count($this->questions) === 0
        ) {
            return 0;
        }

        return intval(
            (
                ($this->currentQuestionIndex + 1)
                /
                count($this->questions)
            ) * 100
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.forms.form-runner',
            [
                'question' =>
                    $this->currentQuestion,
            ]
        );
    }
}