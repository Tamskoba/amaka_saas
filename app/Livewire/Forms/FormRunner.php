<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use Livewire\Component;
use App\Models\ResponseSet;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSession;



class FormRunner extends Component
{
    public Form $form;
    public array $sections = [];
    public array $questions = [];
    public array $answers = [];
    public int $currentQuestionIndex = 0;
    public ?array $currentQuestion = null;
    public ?UserSession $session = null;

    public function previousQuestion(): void
    {
        if ($this->currentQuestionIndex > 0) {

            $this->currentQuestionIndex--;

            $this->currentQuestion =
                $this->questions[
                    $this->currentQuestionIndex
                ] ?? null;

            if (
                $this->currentQuestion
                &&
                $this->currentQuestion['question_type'] === 'checkbox'
                &&
                ! isset(
                    $this->answers[
                        $this->currentQuestion['id']
                    ]
                )
            ) {

                $this->answers[
                    $this->currentQuestion['id']
                ] = [];
            }
        }
    }

    public function nextQuestion(): void
    {
        if (! $this->currentQuestion) {
            return;
        }

        $question = $this->currentQuestion;

        $answer = $this->answers[$question['id']] ?? null;

        if ($question['is_required']) {

            $isEmpty = false;

            if ($answer === null) {
                $isEmpty = true;
            }

            elseif (is_string($answer) && trim($answer) === '') {
                $isEmpty = true;
            }

            elseif (is_array($answer) && count($answer) === 0) {
                $isEmpty = true;
            }

            if ($isEmpty) {

                $this->addError(
                    'answer',
                    'Cette question est obligatoire.'
                );

                return;
            }
        }

        $this->resetErrorBag();

        if (
            $this->currentQuestionIndex
            <
            count($this->questions) - 1
        ) {

            $this->currentQuestionIndex++;

            $this->currentQuestion =
                $this->questions[
                    $this->currentQuestionIndex
                ] ?? null;

            // Initialisation des checkbox
            if (
                $this->currentQuestion
                &&
                $this->currentQuestion['question_type'] === 'checkbox'
                &&
                ! isset(
                    $this->answers[
                        $this->currentQuestion['id']
                    ]
                )
            ) {

                $this->answers[
                    $this->currentQuestion['id']
                ] = [];
            }

            return;
        }

        $this->saveResponses();
    }

    public function getProgressProperty()
    {
        if (count($this->questions) === 0) {
            return 0;
        }

        return intval(
            (($this->currentQuestionIndex + 1)
            / count($this->questions)) * 100
        );
    }

    public function updatedAnswers(): void
    {
        $this->resetErrorBag('answer');
    }

    public function mount(Form $form): void
    {
        $this->form = $form;

        $this->session = UserSession::where(
                'user_id',
                auth()->id()
            )
            ->where(
                'status',
                'active'
            )
            ->latest()
            ->first();

        if (! $this->session) {

            $lastSessionNumber =
                UserSession::where(
                    'user_id',
                    auth()->id()
                )
                ->max('session_number');

            $this->session = UserSession::create([

                'user_id' => auth()->id(),

                'session_number' =>
                    ($lastSessionNumber ?? 0) + 1,

                'status' => 'active',

            ]);
        }
        
        $this->sections = $form
            ->sections()
            ->with([
                'questions.options'
            ])
            ->orderBy('sort_order')
            ->get()
            ->toArray();

        $this->questions = [];

        foreach ($this->sections as $section) {

            foreach ($section['questions'] as $question) {

                $this->questions[] = $question;

                if (
                    $question['question_type'] === 'checkbox'
                    &&
                    !isset($this->answers[$question['id']])
                ) {

                    $this->answers[$question['id']] = [];
                }
            }
        }

        $this->currentQuestion = $this->questions[0] ?? null;
        
        $lastResponseSet = ResponseSet::where(
                'user_id',
                Auth::id()
            )
            ->where(
                'form_id',
                $this->form->id
            )
            ->latest()
            ->first();

        if ($lastResponseSet) {

            foreach ($lastResponseSet->answers as $answer) {

                $value = $answer->answer_value;

                if (
                    is_string($value)
                    &&
                    str_starts_with(trim($value), '[')
                ) {

                    $this->answers[$answer->question_id]
                        = json_decode($value, true);

                } else {

                    $this->answers[$answer->question_id]
                        = $value;
                }
            }

            $answeredQuestionIds = collect(
                $lastResponseSet->answers
            )
            ->pluck('question_id')
            ->toArray();

            foreach (
                $this->questions as $index => $question
            ) {

                if (
                    ! in_array(
                        $question['id'],
                        $answeredQuestionIds
                    )
                ) {

                    $this->currentQuestionIndex = $index;

                    $this->currentQuestion =
                        $this->questions[$index];

                    break;
                }
            }
        }
        //dd($this->answers);
    }

    public function render()
    {
        return view(
            'livewire.forms.form-runner',
            [
                'question' => $this->currentQuestion,
            ]
        );
    }

    public function saveResponses(): void
    {
        $responseSet = ResponseSet::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'form_id' => $this->form->id,
                'session_id' => $this->session->id,
            ],
            [
                'status' => 'completed',
                'progress' => 100,
                'completed_at' => now(),
            ]
        );

        foreach ($this->answers as $questionId => $answer) {

            Answer::create([
                'response_set_id' => $responseSet->id,
                'question_id'     => $questionId,

                'answer_text' => is_array($answer)
                    ? json_encode($answer)
                    : (string) $answer,

                'answer_value' => is_array($answer)
                    ? json_encode($answer)
                    : (string) $answer,
            ]);
        }

        $this->currentQuestion = null;

        $assignedFormsCount =
            auth()->user()
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

        if ($completedFormsCount >= $assignedFormsCount) {

            $this->session->update([

                'status' => 'completed',

                'completed_at' => now(),

            ]);
        }    
    }
}