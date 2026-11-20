<?php

namespace App\Services\Synthesis;

use App\Models\Answer;
use App\Models\ResponseSet;
use Illuminate\Support\Collection;

class DetailedSynthesisBuilder
{
    private const EMPTY_MESSAGE = 'Aucune information disponible dans les questionnaires';

    /**
     * Construit les 20 rubriques du mode Détaillé à partir des réponses
     * réellement enregistrées pour les ResponseSet de la session.
     *
     * Les données originales ne sont jamais modifiées.
     */
    public function build(Collection $responseSets): array
    {
        $configuration = config('detailed_synthesis', []);
        $rubricDefinitions = $configuration['rubrics'] ?? [];

        // Index des réponses par question_key. On conserve toutes les occurrences
        // (notamment si une même question est présente dans plusieurs ResponseSet).
        $answersByKey = [];

        foreach ($responseSets as $responseSet) {
            foreach ($responseSet->answers as $answer) {
                $question = $answer->question;
                $questionKey = $question?->question_key;

                if (!$questionKey) {
                    continue;
                }

                $answersByKey[$questionKey][] = [
                    'answer' => $answer,
                    'question' => $question,
                    'form_title' => $responseSet->form?->title
                        ?? 'Questionnaire sans titre',
                    'status' => $responseSet->status,
                    'progress' => (int) ($responseSet->progress ?? 0),
                ];
            }
        }

        $rubrics = [];

        foreach ($rubricDefinitions as $definition) {
            $items = [];

            foreach (($definition['sources'] ?? []) as $sourceDefinition) {
                $questionKey = $sourceDefinition['question_key'] ?? null;

                if (!$questionKey || empty($answersByKey[$questionKey])) {
                    continue;
                }

                foreach ($answersByKey[$questionKey] as $entry) {
                    /** @var Answer $answer */
                    $answer = $entry['answer'];
                    $question = $entry['question'];

                    $formattedAnswer = $this->formatAnswer($answer, $question);

                    // Une réponse réellement vide n'est pas transformée en "Non"
                    // et ne crée pas artificiellement une information disponible.
                    if ($formattedAnswer === null) {
                        continue;
                    }

                    $items[] = [
                        'question_key' => $questionKey,
                        'question' => $question?->question_text
                            ?? ($sourceDefinition['question'] ?? 'Question sans libellé'),
                        'answer' => $formattedAnswer,
                        'questionnaire' => $entry['form_title'],
                        'section' => $question?->section?->title
                            ?? ($sourceDefinition['section'] ?? 'Section non renseignée'),
                        'status' => $this->formatStatus($entry['status']),
                        'progress' => $entry['progress'],
                        'mapping_role' => $sourceDefinition['mapping_role'] ?? 'primary',
                    ];
                }
            }

            $rubrics[] = [
                'number' => (int) ($definition['number'] ?? 0),
                'key' => $definition['key'] ?? '',
                'title' => $definition['title'] ?? 'Rubrique sans titre',
                'coverage' => $definition['coverage'] ?? null,
                'source_summary' => $definition['source_summary'] ?? null,
                'limitations' => $definition['limitations'] ?? null,
                'items' => $items,
                'has_data' => $items !== [],
                'empty_message' => $items === [] ? self::EMPTY_MESSAGE : null,
            ];
        }

        return [
            'title' => $configuration['title'] ?? 'Synthèse fonctionnelle détaillée',
            'rubrics' => $rubrics,
            'empty_message' => self::EMPTY_MESSAGE,
            'has_data' => collect($rubrics)->contains(
                fn (array $rubric) => $rubric['has_data']
            ),
        ];
    }

    /**
     * Retourne null uniquement si aucune réponse exploitable n'a été saisie.
     * Les valeurs booléennes false et numériques 0 sont conservées.
     */
    private function formatAnswer(Answer $answer, $question): ?string
    {
        $raw = $answer->answer_text;

        if ($raw === null || $raw === '') {
            $raw = $answer->answer_value;
        }

        if ($raw === null || $raw === '') {
            return null;
        }

        $decoded = $raw;

        if (is_string($raw)) {
            $candidate = json_decode($raw, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $decoded = $candidate;
            }
        }

        if ($decoded === null || $decoded === '' || $decoded === []) {
            return null;
        }

        if (is_array($decoded) && array_key_exists('value', $decoded)) {
            $value = $this->formatValue($decoded['value'], $question);
            $frequency = $decoded['frequency'] ?? null;

            if (is_array($frequency)) {
                $frequencyParts = [];

                foreach ($frequency as $optionValue => $frequencyValue) {
                    if ($frequencyValue === null || $frequencyValue === '') {
                        continue;
                    }

                    $frequencyParts[] = $this->optionLabel(
                        $question,
                        (string) $optionValue
                    ) . ' : ' . $frequencyValue;
                }

                $frequency = implode('; ', $frequencyParts);
            }

            if ($value === '') {
                return null;
            }

            return $value . (
                is_string($frequency) && trim($frequency) !== ''
                    ? ' — Fréquence : ' . $frequency
                    : ''
            );
        }

        return $this->formatValue($decoded, $question);
    }

    private function formatValue(mixed $value, $question): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        if (is_bool($value)) {
            return $value ? 'Oui' : 'Non';
        }

        if (is_array($value)) {
            $values = [];

            foreach ($value as $key => $item) {
                if (is_array($item)) {
                    $formatted = $this->formatValue($item, $question);
                    if ($formatted !== '') {
                        $values[] = $formatted;
                    }
                } elseif (is_string($key)) {
                    $values[] = $this->optionLabel($question, $key)
                        . ' : ' . (string) $item;
                } else {
                    $values[] = $this->optionLabel($question, (string) $item);
                }
            }

            return implode(', ', array_filter($values, fn ($item) => $item !== ''));
        }

        return $this->optionLabel($question, trim((string) $value));
    }

    private function optionLabel($question, string $value): string
    {
        if ($question) {
            foreach ($question->options as $option) {
                if ((string) $option->option_value === $value) {
                    return (string) $option->option_label;
                }
            }
        }

        return $value;
    }

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