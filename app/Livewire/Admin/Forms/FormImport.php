<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Form;
use App\Models\FormSection;
use App\Models\Question;
use App\Models\QuestionOption;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormImport extends Component
{
    use WithFileUploads;
    
    protected $rules = [
        'files.*' => 'required|file|mimes:json,txt'
    ];  

    public array $files = [];

    public function import(): void
    {

// $content = file_get_contents(
//     $this->files[0]->getRealPath()
// );

// $content = str_replace(
//     ['```json', '```'],
//     '',
//     $content
// );

// $data = json_decode($content, true);

// dd(
//     json_last_error_msg(),
//     $data['title'] ?? null
// );
        foreach ($this->files as $file) {

            try {

                $json = file_get_contents(

                    $file->getRealPath()

                );

                $json = str_replace(['```json', '```'],'',$json);

                $data = json_decode($json, true);

                if (!$data) {

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | AVOID DUPLICATES
                |--------------------------------------------------------------------------
                */

                $exists = Form::where(

                    'title',

                    $data['title']

                )->exists();

                if ($exists) {

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | FORM
                |--------------------------------------------------------------------------
                */

                $form = Form::create([

                    'title' => $data['title'],

                    'description' => $data['description'] ?? null,

                    'is_active' => $data['is_active'] ?? true,

                ]);

                /*
                |--------------------------------------------------------------------------
                | SECTIONS
                |--------------------------------------------------------------------------
                */

                foreach (

                    $data['sections']

                    as $sectionIndex => $sectionData

                ) {

                    $section = FormSection::create([

                        'form_id' => $form->id,

                        'title' => $sectionData['title'],

                        'description' => $sectionData['description'] ?? null,

                        'sort_order' => $sectionIndex,

                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | QUESTIONS
                    |--------------------------------------------------------------------------
                    */

                    foreach (

                        $sectionData['questions']

                        as $questionIndex => $questionData

                    ) {
                        //dd($questionData);
                        $question = Question::create([
                            'form_id' => $form->id,

                            'section_id' => $section->id,

                            'question_text' => $questionData['question_text'],

                            'question_type' => $questionData['question_type'],

                            'placeholder' => $questionData['placeholder'] ?? null,

                            'help_text' => $questionData['help_text'] ?? null,

                            'is_required' => $questionData['is_required'] ?? false,

                            'sort_order' => $questionIndex,

                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | OPTIONS
                        |--------------------------------------------------------------------------
                        */

                        if (

                            isset($questionData['options'])

                        ) {

                            foreach (

                                $questionData['options']

                                as $optionIndex => $optionData

                            ) {

                                QuestionOption::create([

                                    'question_id' => $question->id,
                                    'option_label' => $optionData['label'],
                                    'option_value' => $optionData['value'],
                                    'option_score' => $optionData['score'] ?? 0,
                                    'sort_order' => $optionIndex,

                                ]);
                            }
                        }
                    }
                }

            } catch (\Exception $e) {

                logger($e);
            }
        }

        session()->flash(

            'success',

            'Import terminé avec succès.'

        );

        $this->redirectRoute('admin.forms');
    }

    public function render()
    {
        return view(
            'livewire.admin.forms.form-import'
        )

        ->layout('components.layouts.admin');
    }  
}