<?php

namespace App\Services\Synthesis;

use App\Models\Answer;
use App\Models\FunctionalSynthesis;
use App\Models\ResponseSet;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class FunctionalSynthesisGenerator
{
    /**
     * Génère ou met à jour la synthèse brute d'un client
     * pour une session donnée.
     */
    public function generate(
        User $user,
        UserSession $session
    ): FunctionalSynthesis {
        if ((int) $session->user_id !== (int) $user->id) {
            throw new InvalidArgumentException(
                'Cette session ne correspond pas au client sélectionné.'
            );
        }

        return DB::transaction(function () use ($user, $session) {
            $responseSets = ResponseSet::query()
                ->where('user_id', $user->id)
                ->where('session_id', $session->id)
                ->with([
                    'form.sections' => function ($query) {
                        $query->orderBy('sort_order')
                            ->orderBy('id');
                    },
                    'form.sections.questions' => function ($query) {
                        $query->orderBy('sort_order')
                            ->orderBy('id');
                    },
                    'form.sections.questions.options',
                    'answers.question.options',
                    'answers.question.section',
                ])
                ->orderBy('form_id')
                ->orderBy('id')
                ->get();

            $content = $this->buildContent($responseSets);

            return FunctionalSynthesis::updateOrCreate(
                [
                    'session_id' => $session->id,
                ],
                [
                    'user_id' => $user->id,
                    'content' => $content,
                    'generated_at' => now(),
                ]
            );
        });
    }

    /**
     * Construit le contenu de la synthèse.
     */
    private function buildContent(Collection $responseSets): string
    {
        $lines = [];

        $lines[] = 'SYNTHÈSE FONCTIONNELLE BRUTE';
        $lines[] = '========================================';
        $lines[] = '';
        $lines[] = 'Document de collecte des réponses déclarées.';
        $lines[] = 'Aucune interprétation ni aucun diagnostic automatique.';
        $lines[] = '';

        if ($responseSets->isEmpty()) {
            $lines[] = 'Aucune réponse enregistrée pour cette session.';

            return implode("\n", $lines);
        }

        foreach ($responseSets as $responseSet) {
            $form = $responseSet->form;

            $lines[] = '';
            $lines[] = '----------------------------------------';
            $lines[] = 'QUESTIONNAIRE : ' . (
                $form?->title ?? 'Questionnaire sans titre'
            );
            $lines[] = 'Statut : ' . $this->formatStatus(
                $responseSet->status
            );
            $lines[] = 'Progression : ' . (
                $responseSet->progress ?? 0
            ) . ' %';
            $lines[] = '';

            if (!$form) {
                $lines[] = 'Le questionnaire associé est introuvable.';
                continue;
            }

            $answersByQuestion = $responseSet->answers
                ->keyBy('question_id');

            $sections = $form->sections
                ->sortBy([
                    ['sort_order', 'asc'],
                    ['id', 'asc'],
                ]);

            if ($sections->isEmpty()) {
                $this->appendAnswersWithoutSections(
                    $lines,
                    $responseSet->answers
                );

                continue;
            }

            foreach ($sections as $section) {
                $sectionQuestions = $section->questions
                    ->sortBy([
                        ['sort_order', 'asc'],
                        ['id', 'asc'],
                    ]);

                $answeredQuestions = $sectionQuestions->filter(
                    fn ($question) => $answersByQuestion->has(
                        $question->id
                    )
                );

                if ($answeredQuestions->isEmpty()) {
                    continue;
                }

                $sectionTitle = $section->title ?? 'Section sans titre';

                $lines[] = $sectionTitle;
                $lines[] = str_repeat(
                    '-',
                    max(1, mb_strlen($sectionTitle))
                );

                if (!empty($section->description)) {
                    $lines[] = $section->description;
                }

                foreach ($answeredQuestions as $question) {
                    $answer = $answersByQuestion->get($question->id);

                    $lines[] = '';
                    $lines[] = $question->question_text;
                    $lines[] = 'Réponse : ' . $this->formatAnswer(
                        $answer,
                        $question
                    );
                }

                $lines[] = '';
            }

            /*
             * Inclut les réponses dont la question n'apparaît plus
             * dans les sections actuellement chargées.
             */
            $knownQuestionIds = $form->sections
                ->flatMap(fn ($section) => $section->questions)
                ->pluck('id')
                ->all();

            $orphanAnswers = $responseSet->answers->filter(
                fn ($answer) => !in_array(
                    $answer->question_id,
                    $knownQuestionIds
                )
            );

            if ($orphanAnswers->isNotEmpty()) {
                $lines[] = 'AUTRES RÉPONSES ENREGISTRÉES';

                $this->appendAnswersWithoutSections(
                    $lines,
                    $orphanAnswers
                );
            }
        }

        $lines[] = '';
        $lines[] = '========================================';
        $lines[] = 'FIN DE LA SYNTHÈSE BRUTE';

        return implode("\n", $lines);
    }

    /**
     * Formate une réponse sans en modifier le sens.
     */
    private function formatAnswer(
        Answer $answer,
        $question = null
    ): string {
        $raw = $answer->answer_text;

        if ($raw === null || $raw === '') {
            $raw = $answer->answer_value;
        }

        if ($raw === null || $raw === '') {
            return 'Réponse enregistrée sans contenu exploitable.';
        }

        $decoded = $this->decodeJson($raw);

        /*
         * Réponse temporelle :
         * {"value": "...", "frequency": "..."}
         */
        if (
            is_array($decoded)
            && array_key_exists('value', $decoded)
            && array_key_exists('frequency', $decoded)
        ) {
            $value = $this->formatValue(
                $decoded['value'],
                $question
            );

            $frequency = $this->formatFrequency(
                $decoded['frequency'],
                $question
            );

            if ($frequency !== '') {
                return $value . ' — Fréquence : ' . $frequency;
            }

            return $value;
        }

        /*
         * Autres réponses JSON, notamment les cases à cocher.
         */
        if (is_array($decoded)) {
            return $this->formatValue($decoded, $question);
        }

        /*
         * Réponse simple : on essaie de retrouver le libellé
         * de l'option, sinon on conserve la valeur enregistrée.
         */
        return $this->getOptionLabel(
            $question,
            trim((string) $decoded)
        );
    }

    /**
     * Décode une chaîne JSON si nécessaire.
     */
    private function decodeJson(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        $trimmed = trim($value);

        if ($trimmed === '') {
            return $value;
        }

        $decoded = json_decode($trimmed, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        return $value;
    }

    /**
     * Formate une valeur simple ou une liste de valeurs.
     * Les valeurs correspondant aux options sont remplacées
     * par leurs libellés lorsque ceux-ci existent.
     */
    private function formatValue(
        mixed $value,
        $question = null
    ): string {
        if ($value === null || $value === '') {
            return 'Valeur vide';
        }

        if (is_bool($value)) {
            return $value ? 'Oui' : 'Non';
        }

        if (is_array($value)) {
            if ($value === []) {
                return 'Aucune option sélectionnée';
            }

            $formatted = [];

            foreach ($value as $key => $item) {
                if (is_array($item)) {
                    $formatted[] = $this->formatValue(
                        $item,
                        $question
                    );

                    continue;
                }

                /*
                 * Format associatif : clé = valeur d'option,
                 * contenu = fréquence ou autre donnée.
                 */
                if (is_string($key) && !is_int($key)) {
                    $label = $this->getOptionLabel(
                        $question,
                        (string) $key
                    );

                    $formatted[] = $label . ' : ' . (string) $item;

                    continue;
                }

                $formatted[] = $this->getOptionLabel(
                    $question,
                    (string) $item
                );
            }

            return implode(', ', $formatted);
        }

        return $this->getOptionLabel(
            $question,
            trim((string) $value)
        );
    }

    /**
     * Formate une fréquence simple ou une fréquence par option.
     */
    private function formatFrequency(
        mixed $frequency,
        $question = null
    ): string {
        if ($frequency === null || $frequency === '') {
            return '';
        }

        if (!is_array($frequency)) {
            return trim((string) $frequency);
        }

        $parts = [];

        foreach ($frequency as $optionValue => $frequencyValue) {
            if ($frequencyValue === null || $frequencyValue === '') {
                continue;
            }

            $optionLabel = $this->getOptionLabel(
                $question,
                (string) $optionValue
            );

            $parts[] = $optionLabel . ' : ' . $frequencyValue;
        }

        return implode('; ', $parts);
    }

    /**
     * Retrouve le libellé d'une option à partir de sa valeur.
     *
     * Les vrais champs de QuestionOption sont :
     * - option_value
     * - option_label
     *
     * Si aucune option ne correspond, la valeur d'origine
     * est conservée afin de ne pas inventer de libellé.
     */
    private function getOptionLabel(
        $question,
        string $value
    ): string {
        if ($question) {
            foreach ($question->options as $option) {
                if ((string) $option->option_value === $value) {
                    return (string) $option->option_label;
                }
            }
        }

        return $value;
    }

    /**
     * Ajoute les réponses qui ne peuvent pas être rattachées
     * à une section actuellement chargée.
     */
    private function appendAnswersWithoutSections(
        array &$lines,
        Collection $answers
    ): void {
        foreach ($answers as $answer) {
            $question = $answer->question;

            $lines[] = '';
            $lines[] = $question?->question_text
                ?? 'Question introuvable (ID : ' . $answer->question_id . ')';

            $lines[] = 'Réponse : ' . $this->formatAnswer(
                $answer,
                $question
            );
        }
    }

    /**
     * Présente le statut enregistré.
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
}