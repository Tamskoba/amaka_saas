<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Form;
use App\Models\FormSection;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;
use JsonException;
use RuntimeException;

class FormImport extends Component
{
    use WithFileUploads;

    protected $rules = [
        'files' => 'required|array|min:1',
        'files.*' => 'required|file|mimes:json,txt|max:10240',
    ];

    public array $files = [];

    public function import(): void
    {
        // Les erreurs de validation Livewire restent visibles dans le formulaire.
        $this->validate();

        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($this->files as $file) {
            $fileName = $file->getClientOriginalName();

            try {
                $json = file_get_contents($file->getRealPath());

                if ($json === false || trim($json) === '') {
                    throw new RuntimeException(
                        'Le fichier est vide ou impossible à lire.'
                    );
                }

                // Accepte un JSON brut ou un JSON entouré de balises Markdown.
                $json = preg_replace(
                    '/^\xEF\xBB\xBF/',
                    '',
                    trim($json)
                );

                $json = preg_replace(
                    '/^```(?:json)?\s*/i',
                    '',
                    $json
                );

                $json = preg_replace(
                    '/\s*```\s*$/',
                    '',
                    $json
                );

                // Une erreur de syntaxe JSON produit un message explicite.
                try {
                    $data = json_decode(
                        $json,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );
                } catch (JsonException $e) {
                    throw new RuntimeException(
                        'JSON invalide : ' . $e->getMessage()
                    );
                }

                if (!is_array($data)) {
                    throw new RuntimeException(
                        'Le contenu JSON doit être un objet.'
                    );
                }

                // Validation de la structure attendue par Amaka SaaS.
                $validator = Validator::make($data, [
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'is_active' => 'sometimes|boolean',

                    'sections' => 'required|array|min:1',
                    'sections.*' => 'required|array',
                    'sections.*.title' => 'required|string|max:255',
                    'sections.*.description' => 'nullable|string',
                    'sections.*.questions' => 'sometimes|array',

                    'sections.*.questions.*' => 'required|array',
                    'sections.*.questions.*.question_text'
                        => 'required|string',
                    'sections.*.questions.*.question_type'
                        => 'required|string',
                    'sections.*.questions.*.question_key'
                        => 'nullable|string',
                    'sections.*.questions.*.placeholder'
                        => 'nullable|string',
                    'sections.*.questions.*.help_text'
                        => 'nullable|string',
                    'sections.*.questions.*.is_required'
                        => 'sometimes|boolean',
                    'sections.*.questions.*.has_frequency'
                        => 'sometimes|boolean',
                    'sections.*.questions.*.options'
                        => 'sometimes|array',
                    'sections.*.questions.*.options.*'
                        => 'required|array',
                    'sections.*.questions.*.options.*.label'
                        => 'nullable|string',
                    'sections.*.questions.*.options.*.value'
                        => 'nullable|string',
                    'sections.*.questions.*.options.*.score'
                        => 'nullable|numeric',
                    'sections.*.questions.*.depends_on'
                        => 'sometimes|nullable|array',
                ]);

                if ($validator->fails()) {
                    $details = $validator->errors()->all();

                    throw new RuntimeException(
                        'Structure du questionnaire incorrecte : '
                        . implode(' ; ', $details)
                    );
                }

                // Ignorer les questionnaires déjà présents.
                if (Form::where('title', $data['title'])->exists()) {
                    $skipped++;

                    Log::warning('Import ignoré : questionnaire déjà existant.', [
                        'file' => $fileName,
                        'title' => $data['title'],
                    ]);

                    continue;
                }

                DB::transaction(function () use ($data) {
                    $form = Form::create([
                        'title' => $data['title'],
                        'description' => $data['description'] ?? null,
                        'is_active' => $data['is_active'] ?? true,
                    ]);

                    foreach ($data['sections'] as $sectionIndex => $sectionData) {
                        $section = FormSection::create([
                            'form_id' => $form->id,
                            'title' => $sectionData['title'],
                            'description' => $sectionData['description'] ?? null,
                            'sort_order' => $sectionIndex,
                        ]);

                        foreach (
                            ($sectionData['questions'] ?? [])
                            as $questionIndex => $questionData
                        ) {
                            $question = Question::create([
                                'form_id' => $form->id,
                                'section_id' => $section->id,
                                'question_key' =>
                                    $questionData['question_key'] ?? null,
                                'question_text' =>
                                    $questionData['question_text'],
                                'question_type' =>
                                    $questionData['question_type'],
                                'placeholder' =>
                                    $questionData['placeholder'] ?? null,
                                'help_text' =>
                                    $questionData['help_text'] ?? null,
                                'is_required' =>
                                    $questionData['is_required'] ?? false,
                                'has_frequency' =>
                                    $questionData['has_frequency'] ?? false,
                                'sort_order' => $questionIndex,
                                'conditional_logic' =>
                                    $questionData['depends_on'] ?? null,
                            ]);

                            foreach (
                                ($questionData['options'] ?? [])
                                as $optionIndex => $optionData
                            ) {
                                QuestionOption::create([
                                    'question_id' => $question->id,
                                    'option_label' =>
                                        $optionData['label'] ?? '',
                                    'option_value' =>
                                        $optionData['value'] ?? '',
                                    'option_score' =>
                                        $optionData['score'] ?? 0,
                                    'sort_order' => $optionIndex,
                                ]);
                            }
                        }
                    }
                });

                $imported++;

                Log::info('Questionnaire importé avec succès.', [
                    'file' => $fileName,
                    'title' => $data['title'],
                ]);
            } catch (Throwable $e) {
                Log::error('Échec de l’import du questionnaire.', [
                    'file' => $fileName,
                    'error' => $e->getMessage(),
                    'exception' => get_class($e),
                ]);

                $errors[] = $fileName . ' : ' . $e->getMessage();
            }
        }

        $message = $imported . ' importé(s), '
            . $skipped . ' ignoré(s), '
            . count($errors) . ' erreur(s).';

        if (!empty($errors)) {
            $message .= ' Détails : ' . implode(' | ', $errors);
        }

        if ($imported > 0 && empty($errors) && $skipped === 0) {
            session()->flash('success', $message);
        } elseif (!empty($errors)) {
            session()->flash('import_result', $message);
        } elseif ($skipped > 0 && $imported === 0) {
            session()->flash('import_result', $message);
        } else {
            session()->flash('import_result', $message);
        }

        $this->redirectRoute('admin.forms');
    }

    public function render()
    {
        return view('livewire.admin.forms.form-import')
            ->layout('components.layouts.admin');
    }
}