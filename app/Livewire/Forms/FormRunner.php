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

    public string $editUrl = '';

    protected QuestionnaireEngine $engine;

    /**
     * Vérifie que l'utilisateur connecté est autorisé
     * à accéder à ce questionnaire.
     */
    protected function authorizeFormAccess(): void
    {
        abort_unless(Auth::check(), 403);

        $user = Auth::user();

        $hasAccess = $user->forms()
            ->where('forms.id', $this->form->id)
            ->where('forms.is_active', 1)
            ->where('forms.is_deleted', 0)
            ->wherePivot('is_visible', 1)
            ->exists();

        abort_unless(
            $hasAccess,
            403,
            'Ce questionnaire ne vous est pas attribué.'
        );
    }

    public function mount(Form $form): void
    {
        $this->form = $form;

        $this->authorizeFormAccess();
       
        // Mémoriser l'URL réelle de la page avant les requêtes Livewire.
        $this->editUrl = request()->fullUrlWithQuery([
            'edit' => 1,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Mode consultation / modification
        |--------------------------------------------------------------------------
        |
        | Sans ?edit=1 :
        |   - questionnaire en cours → continuer
        |   - questionnaire terminé → consulter les réponses
        |
        | Avec ?edit=1 :
        |   - questionnaire terminé → modifier les réponses
        |
        */
        $this->isEditMode = request()->boolean('edit');

        $this->isEditing = $this->isEditMode;

        /*
        |--------------------------------------------------------------------------
        | Chargement du moteur du questionnaire
        |--------------------------------------------------------------------------
        */

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
        //@dd($this->answers);

            /* dd(
            \App\Models\QuestionOption::where('question_id', 826)
                ->orderBy('sort_order')
                ->get([
                    'question_id',
                    'option_label',
                    'option_value',
                    'option_score',
                    'sort_order',
                ])
                ->toArray()
        ); */
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
        | IMPORTANT :
        | Un questionnaire terminé reste maintenant consultable.
        |
        | On ne met donc PLUS currentQuestion à null lorsque
        | isCompleted = true.
        |
        |--------------------------------------------------------------------------
        */

        $this->currentQuestion = null;

        /*
        |--------------------------------------------------------------------------
        | Recherche de la première question visible
        |--------------------------------------------------------------------------
        */

        foreach ($this->questions as $index => $question) {
            if ($this->shouldShowQuestion($question)) {
                $this->currentQuestionIndex = $index;
                $this->currentQuestion = $question;
                break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Pour un questionnaire non terminé :
        | on se positionne sur la première question sans réponse.
        |
        | Pour un questionnaire terminé :
        | on reste sur la première question afin de permettre
        | la consultation des réponses.
        |--------------------------------------------------------------------------
        */

        if (! $this->isCompleted && ! $this->isEditMode) {
            foreach ($this->questions as $index => $question) {
                if (! $this->shouldShowQuestion($question)) {
                    continue;
                }

                if (! $this->isQuestionAnswered($question)) {
                    $this->currentQuestionIndex = $index;
                    $this->currentQuestion = $question;
                    break;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Initialisation d'une réponse checkbox
        |--------------------------------------------------------------------------
        */

        $this->initializeCheckboxAnswer($this->currentQuestion);
    }

    /*
    |--------------------------------------------------------------------------
    | QUESTION PRÉCÉDENTE
    |--------------------------------------------------------------------------
    */

    public function previousQuestion(): void
    {
        $this->authorizeFormAccess();

        if ($this->isCompleted && $this->isEditMode === false) {
            // La navigation arrière est autorisée en consultation.
            // Continuer normalement vers la question précédente.
        }

        if ($this->currentQuestionIndex <= 0) {
            return;
        }

        $index = $this->currentQuestionIndex - 1;

        while ($index >= 0) {
            $question = $this->questions[$index] ?? null;

            if (
                $question
                && $this->shouldShowQuestion($question)
            ) {
                $this->currentQuestionIndex = $index;

                $this->currentQuestion = $question;

                $this->initializeCheckboxAnswer($question);

                $this->resetErrorBag();

                return;
            }

            $index--;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | QUESTION SUIVANTE
    |--------------------------------------------------------------------------
    */
 
    public function nextQuestion(): void
    {
        $this->authorizeFormAccess();

        if (! $this->currentQuestion) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | CONSULTATION D'UN QUESTIONNAIRE TERMINÉ
        |--------------------------------------------------------------------------
        |
        | On autorise la navigation, mais aucune validation ni sauvegarde.
        |
        */

        if ($this->isCompleted && ! $this->isEditMode) {
            $nextIndex = $this->currentQuestionIndex + 1;

            while ($nextIndex < count($this->questions)) {
                $nextQuestion = $this->questions[$nextIndex];

                if ($this->shouldShowQuestion($nextQuestion)) {
                    $this->currentQuestionIndex = $nextIndex;
                    $this->currentQuestion = $nextQuestion;

                    return;
                }

                $nextIndex++;
            }

            // Dernière question : aucune sauvegarde en consultation.
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | MODE SAISIE OU MODIFICATION : COMPORTEMENT ACTUEL
        |--------------------------------------------------------------------------
        */

        if (! $this->validateCurrentQuestion()) {
            return;
        }

        $this->resetErrorBag();

        $nextIndex = $this->currentQuestionIndex + 1;

        while ($nextIndex < count($this->questions)) {
            $nextQuestion = $this->questions[$nextIndex];

            if (! $this->shouldShowQuestion($nextQuestion)) {
                $this->removeHiddenQuestionAnswer($nextQuestion);
                $nextIndex++;

                continue;
            }

            $this->currentQuestionIndex = $nextIndex;
            $this->currentQuestion = $nextQuestion;

            $this->initializeCheckboxAnswer($nextQuestion);

            return;
        }

        $this->saveResponses();
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION DE LA QUESTION COURANTE
    |--------------------------------------------------------------------------
    */

    protected function validateCurrentQuestion(): bool
    {
        $question = $this->currentQuestion;

        if (! $question) {
            return true;
        }

        $questionId = $question['id'];

        $answer = $this->answers[$questionId] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Question conditionnelle devenue invisible
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
        | Ancien système de fréquence
        |--------------------------------------------------------------------------
        |
        | Conservé pour compatibilité avec les anciens questionnaires.
        | Les nouveaux questionnaires sans has_frequency ne sont
        | pas concernés.
        |
        |--------------------------------------------------------------------------
        */

        if ($this->isTemporalQuestion($question)) {
            if (($question['question_type'] ?? null) === 'checkbox') {
                $selected = is_array($answer) ? array_map('strval', $answer) : [];
                $frequencyMap = $this->frequencies[$questionId] ?? [];
                if (! is_array($frequencyMap)) {
                    $frequencyMap = [];
                }
                foreach ($selected as $selectedValue) {
                    if ($this->isNoneOption($question, $selectedValue)) {
                        continue;
                    }
                    if (empty($frequencyMap[$selectedValue] ?? null)) {
                        $this->addError('frequency', 'Veuillez préciser la fréquence pour chaque réponse sélectionnée.');
                        return false;
                    }
                }
            } elseif (
                $this->isAffirmativeAnswer($answer)
                && empty($this->frequencies[$questionId] ?? null)
            ) {
                $this->addError('frequency', 'Veuillez préciser la fréquence.');
                return false;
            }
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | QUESTION AVEC FRÉQUENCE
    |--------------------------------------------------------------------------
    */

    /**
     * Indique si une réponse signifie explicitement « oui ».
     *
     * La fréquence n'est exigée que pour une réponse affirmative,
     * et non pour « Non » ou une réponse vide.
     */
    protected function isAffirmativeAnswer(mixed $answer): bool
    {
        if (is_bool($answer)) {
            return $answer;
        }

        if (is_numeric($answer) && (string) $answer === '1') {
            return true;
        }

        if (! is_string($answer)) {
            return false;
        }

        return in_array(
            mb_strtolower(trim($answer)),
            ['oui', 'yes', 'true', '1'],
            true
        );
    }

    public function isTemporalQuestion(array $question): bool
    {
        return filter_var(
            $question['has_frequency'] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );
    }

    /** Indique si la fréquence doit être affichée pour la réponse courante. */
    public function shouldShowFrequencyForAnswer(array $question, mixed $answer): bool
    {
        if (! $this->isTemporalQuestion($question)) {
            return false;
        }

        if (($question['question_type'] ?? null) === 'checkbox') {
            return is_array($answer) && in_array((string) $answer, array_map('strval', $answer), true)
                && ! $this->isNoneOption($question, (string) $answer);
        }

        return $this->isAffirmativeAnswer($answer);
    }

    protected function isNoneOption(array $question, string $value): bool
    {
        foreach (($question['options'] ?? []) as $option) {
            $optionValue = (string) ($option['option_value'] ?? $option['value'] ?? '');
            $optionLabel = trim((string) ($option['option_label'] ?? $option['label'] ?? $optionValue));
            if ($optionValue === $value) {
                return mb_strtolower($optionValue) === 'aucun' || mb_strtolower($optionLabel) === 'aucun';
            }
        }
        return mb_strtolower($value) === 'aucun';
    }

    /*
    |--------------------------------------------------------------------------
    | QUESTION CONDITIONNELLE
    |--------------------------------------------------------------------------
    */

    public function isConditionalQuestion(array $question): bool
    {
        return
            isset($question['depends_on'])
            && is_array($question['depends_on'])
            && isset($question['depends_on']['question_key'])
            && array_key_exists(
                'value',
                $question['depends_on']
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VISIBILITÉ D'UNE QUESTION
    |--------------------------------------------------------------------------
    */

    public function shouldShowQuestion(array $question): bool
    {
        if (! $this->isConditionalQuestion($question)) {
            return true;
        }

        $dependency = $question['depends_on'];

        $parentQuestionKey =
            $dependency['question_key'] ?? null;

        $requiredValue =
            $dependency['value'] ?? null;

        if (
            ! $parentQuestionKey
            || $requiredValue === null
        ) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Recherche de la question par question_key
        |--------------------------------------------------------------------------
        */

        $parentQuestion = collect($this->questions)
            ->first(
                fn ($q) =>
                    ($q['question_key'] ?? null) === $parentQuestionKey
                    ||
                    ($q['question_text'] ?? null) === $parentQuestionKey
            );

        if (! $parentQuestion) {
            return false;
        }

        $parentId = $parentQuestion['id'];

        $parentAnswer =
            $this->answers[$parentId] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Checkbox
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Radio / select / autres
        |--------------------------------------------------------------------------
        */

        return
            (string) $parentAnswer
            ===
            (string) $requiredValue;
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION D'UNE RÉPONSE DE QUESTION CACHÉE
    |--------------------------------------------------------------------------
    */

    protected function removeHiddenQuestionAnswer(
        array $question
    ): void {
        if (! $this->isConditionalQuestion($question)) {
            return;
        }

        if (! $this->shouldShowQuestion($question)) {
            unset(
                $this->answers[$question['id']]
            );

            unset(
                $this->frequencies[$question['id']]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RÉPONSE VIDE
    |--------------------------------------------------------------------------
    */

    protected function isEmptyAnswer(mixed $answer): bool
    {
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

    /**
     * Vérifie si une question est réellement terminée.
     * Une checkbox avec fréquence n'est terminée que lorsque
     * chaque option sélectionnée (hors « Aucun ») a une fréquence.
     */
    protected function isQuestionAnswered(array $question): bool
    {
        $questionId = $question['id'];
        $answer = $this->answers[$questionId] ?? null;

        if ($this->isEmptyAnswer($answer)) {
            return false;
        }

        if (! $this->isTemporalQuestion($question)) {
            return true;
        }

        if (($question['question_type'] ?? null) === 'checkbox') {
            if (! is_array($answer)) {
                return false;
            }

            $selectedOptions = array_filter(
                array_map('strval', $answer),
                fn ($value) => ! $this->isNoneOption($question, $value)
            );

            // « Aucun » sélectionné seul ne nécessite aucune fréquence.
            if (empty($selectedOptions)) {
                return true;
            }

            $frequencies = $this->frequencies[$questionId] ?? [];

            if (! is_array($frequencies)) {
                return false;
            }

            foreach ($selectedOptions as $option) {
                if (
                    ! array_key_exists($option, $frequencies)
                    || $frequencies[$option] === null
                    || $frequencies[$option] === ''
                ) {
                    return false;
                }
            }

            return true;
        }

        // Pour une réponse unique, seule une réponse affirmative
        // exige une fréquence.
        if ($this->isAffirmativeAnswer($answer)) {
            $frequency = $this->frequencies[$questionId] ?? null;

            return $frequency !== null && $frequency !== '';
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | INITIALISATION CHECKBOX
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
            $this->answers[$question['id']] = [];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MISE À JOUR DES RÉPONSES
    |--------------------------------------------------------------------------
    |
    | Les checkbox sont gérées côté navigateur par Alpine.js.
    | Livewire reçoit uniquement le tableau final via $wire.set().
    |
    |--------------------------------------------------------------------------
    */


    public function updatedAnswers($value, $key): void
    {
        $this->authorizeFormAccess();

        $this->resetErrorBag();

        $questionId = (int) explode('.', (string) $key)[0];

        $question = collect($this->questions)->first(
            fn ($item) => (int) ($item['id'] ?? 0) === $questionId
        );

        if ($question) {
            if (($question['question_type'] ?? null) === 'checkbox') {
                $selected = is_array($this->answers[$questionId] ?? null)
                    ? array_map('strval', $this->answers[$questionId])
                    : [];

                $frequencyMap = $this->frequencies[$questionId] ?? [];
                $frequencyMap = is_array($frequencyMap) ? $frequencyMap : [];

                $this->frequencies[$questionId] = array_intersect_key(
                    $frequencyMap,
                    array_flip(array_filter(
                        $selected,
                        fn ($v) => ! $this->isNoneOption($question, $v)
                    ))
                );
            } elseif (! $this->isAffirmativeAnswer($this->answers[$questionId] ?? null)) {
                unset($this->frequencies[$questionId]);
            }
        }

        // Nettoyer les réponses et fréquences des questions devenues invisibles.
        foreach ($this->questions as $questionItem) {
            if (
                $this->isConditionalQuestion($questionItem)
                && ! $this->shouldShowQuestion($questionItem)
            ) {
                $this->removeHiddenQuestionAnswer($questionItem);
            }
        }

        // Sauvegarder l'état actuel sans terminer le questionnaire.
        $this->saveProgress();
    }

    /*
    |--------------------------------------------------------------------------
    | MISE À JOUR DES FRÉQUENCES
    |--------------------------------------------------------------------------
    |
    | Lorsqu'une fréquence est sélectionnée, on efface le message
    | d'erreur associé à la fréquence.
    |
    |--------------------------------------------------------------------------
    */

    public function updatedFrequencies($value, $key = null): void
    {
        $this->authorizeFormAccess();

        $this->resetErrorBag('frequency');

        $this->saveProgress();
    }


    public function clearFrequencyError(): void
    {
        $this->authorizeFormAccess();

        $this->resetErrorBag('frequency');
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTREMENT DES RÉPONSES
    |--------------------------------------------------------------------------
    */

    public function saveResponses(): void
    {
        $this->authorizeFormAccess();

        if (! $this->session) {
            return;
        }

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

        /*
        |--------------------------------------------------------------------------
        | Suppression des anciennes réponses
        |--------------------------------------------------------------------------
        |
        | Important pour le mode modification :
        | les anciennes réponses sont remplacées par les nouvelles.
        |
        |--------------------------------------------------------------------------
        */

        Answer::where(
            'response_set_id',
            $responseSet->id
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | Enregistrement des réponses
        |--------------------------------------------------------------------------
        */

        foreach ($this->questions as $question) {
            $questionId = $question['id'];

            /*
            |--------------------------------------------------------------------------
            | Une question cachée n'est pas enregistrée
            |--------------------------------------------------------------------------
            */

            if (! $this->shouldShowQuestion($question)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Aucune réponse
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
            | Ancien système de fréquence
            |--------------------------------------------------------------------------
            */

            if ($this->isTemporalQuestion($question)) {
                $frequency = $this->frequencies[$questionId] ?? null;
                if (($question['question_type'] ?? null) === 'checkbox') {
                    $selected = is_array($answer) ? array_map('strval', $answer) : [];
                    $frequency = is_array($frequency) ? array_intersect_key(
                        $frequency,
                        array_flip(array_filter($selected, fn ($v) => ! $this->isNoneOption($question, $v)))
                    ) : [];
                } elseif (! $this->isAffirmativeAnswer($answer)) {
                    $frequency = null;
                }
                $storedValue = ['value' => $answer, 'frequency' => $frequency];

                $answerText = json_encode(
                    $storedValue,
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                $answerText =
                    is_array($answer)
                    ?
                    json_encode(
                        $answer,
                        JSON_UNESCAPED_UNICODE
                    )
                    :
                    (string) $answer;
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
        | Questionnaire terminé
        |--------------------------------------------------------------------------
        */

        $this->isCompleted = true;

        /*
        |--------------------------------------------------------------------------
        | Vérification de la session globale
        |--------------------------------------------------------------------------
        */

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

        if (
            $assignedFormsCount > 0
            &&
            $completedFormsCount >= $assignedFormsCount
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
        | Fin du mode modification
        |--------------------------------------------------------------------------
        */

        $this->isEditMode = false;

        $this->isEditing = false;

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | On ne met plus currentQuestion à null ici.
        |
        | Cela permet au questionnaire tout juste enregistré de
        | rester consultable immédiatement.
        |
        |--------------------------------------------------------------------------
        */

        $this->currentQuestion = null;
    }

    /**
     * Sauvegarde les réponses en cours sans terminer le questionnaire.
     */
    protected function saveProgress(): void
    {
        $this->authorizeFormAccess();

        if (
            ! $this->session
            || $this->isCompleted
            || $this->isEditMode
            || ! Auth::check()
        ) {
            return;
        }

        $responseSet = ResponseSet::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'form_id' => $this->form->id,
                'session_id' => $this->session->id,
            ],
            [
                'status' => 'progress',
                'completed_at' => null,
            ]
        );

        $visibleQuestions = array_filter(
            $this->questions,
            fn ($question) => $this->shouldShowQuestion($question)
        );

        $answeredCount = 0;

        foreach ($this->questions as $question) {
            $questionId = $question['id'];

            // Supprimer les réponses des questions conditionnelles masquées.
            if (! $this->shouldShowQuestion($question)) {
                Answer::where('response_set_id', $responseSet->id)
                    ->where('question_id', $questionId)
                    ->delete();

                continue;
            }

            $answer = $this->answers[$questionId] ?? null;

            // Une réponse vide ne crée pas de nouvelle ligne.
            // Une ancienne réponse n'est pas effacée ici :
            // cela évite de perdre une réponse pendant une saisie.
            if ($this->isEmptyAnswer($answer)) {
                continue;
            }

            $storedValue = $answer;

            if ($this->isTemporalQuestion($question)) {
                $frequency = $this->frequencies[$questionId] ?? null;

                if (($question['question_type'] ?? null) === 'checkbox') {
                    $selected = is_array($answer)
                        ? array_map('strval', $answer)
                        : [];

                    $frequency = is_array($frequency)
                        ? array_intersect_key(
                            $frequency,
                            array_flip(array_filter(
                                $selected,
                                fn ($v) => ! $this->isNoneOption($question, $v)
                            ))
                        )
                        : [];
                } elseif (! $this->isAffirmativeAnswer($answer)) {
                    $frequency = null;
                }

                $storedValue = [
                    'value' => $answer,
                    'frequency' => $frequency,
                ];
            }

            $answerText = is_array($storedValue)
                ? json_encode($storedValue, JSON_UNESCAPED_UNICODE)
                : (string) $storedValue;

            Answer::updateOrCreate(
                [
                    'response_set_id' => $responseSet->id,
                    'question_id' => $questionId,
                ],
                [
                    // Champ longText : permet de conserver le JSON complet.
                    'answer_text' => $answerText,

                    // Champ string : ne pas y recopier un JSON potentiellement long.
                    'answer_value' => is_array($answer)
                        ? json_encode($answer, JSON_UNESCAPED_UNICODE)
                        : (string) $answer,
                ]
            );

            if ($this->isQuestionAnswered($question)) {
                $answeredCount++;
            }
        }

        $totalVisibleQuestions = count($visibleQuestions);

        $responseSet->update([
            'progress' => $totalVisibleQuestions > 0
                ? (int) round(
                    ($answeredCount / $totalVisibleQuestions) * 100
                )
                : 0,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PROGRESSION
    |--------------------------------------------------------------------------
    */

    public function getProgressProperty(): int
    {
        if (count($this->questions) === 0) {
            return 0;
        }

        return intval(
            (
                ($this->currentQuestionIndex + 1)
                /
                count($this->questions)
            )
            * 100
        );
    }



    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $this->authorizeFormAccess();
        
        return view(
            'livewire.forms.form-runner',
            [
                'question' =>
                    $this->currentQuestion,
            ]
        );
    }
}