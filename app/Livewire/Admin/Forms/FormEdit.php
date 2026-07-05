<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Form;
use App\Models\FormSection;
use App\Models\Question;
use Livewire\Component;
use App\Models\QuestionOption;
use Illuminate\Support\Str;

class FormEdit extends Component
{
    public Form $form;

    public $sections = [];

    public string $title = '';

    public string $description = '';

    public bool $is_active = true;

    public array $questionTypes = [

        'text' => 'Texte',

        'textarea' => 'Texte long',

        'number' => 'Nombre',

        'date' => 'Date',

        'radio' => 'Choix unique',

        'checkbox' => 'Choix multiple',

        'select' => 'Liste déroulante',

    ];


    public function mount(Form $form): void
    {
        $this->form = $form;

        $this->title = $form->title;

        $this->description = $form->description ?? '';

        $this->is_active = $form->is_active;

        $this->loadSections();
    }

    public function loadSections(): void
    {
        $this->sections = FormSection::with(
            'questions.options'
        )

        ->where('form_id', $this->form->id)

        ->orderBy('sort_order')

        ->get()

        ->toArray();
    }

    public function update(): void
    {
        $this->validate([

            'title' => 'required|min:3',

        ]);

        $this->form->update([

            'title' => $this->title,

            'description' => $this->description,

            'is_active' => $this->is_active,

        ]);

        session()->flash(

            'success',

            'Questionnaire mis à jour.'
        );
    }

    public function render()
    {
        return view(
            'livewire.admin.forms.form-edit'
        )

        ->layout('components.layouts.admin');
    }

    public function addSection(): void
    {
        FormSection::create([

            'form_id' => $this->form->id,

            'title' => 'Nouvelle section',

            'sort_order' => 999,

        ]);

        $this->loadSections();
    }

    public function addQuestion(int $sectionId): void
    {
        $section = FormSection::findOrFail($sectionId);

        Question::create([

            'form_id'       => $section->form_id,

            'section_id'    => $sectionId,

            'question_text' => 'Nouvelle question',

            'question_type' => 'text',

            'is_required'   => false,

            'sort_order'    => 999,

        ]);

        $this->loadSections();
    }

public function deleteQuestion(int $questionId): void
{
    $question = Question::find($questionId);

    if (!$question) {
        return;
    }

    if ($question->answers()->exists()) {

        $this->dispatch(
            'notify',
            type: 'error',
            message: 'Impossible de supprimer une question ayant déjà reçu des réponses.'
        );

        return;
    }

    $question->delete();

    $this->loadSections();
}

    public function updateSectionTitle($sectionId,$title): void
    {
        FormSection::where(

            'id',

            $sectionId

        )->update([

            'title' => trim($title)

        ]);
    }   

    public function updateSectionDescription($sectionId,$description): void
    {
        FormSection::where(

            'id',

            $sectionId

        )->update([

            'description' => trim($description)

        ]);
    }   

    public function updateQuestionText($questionId,$text): void
    {
        Question::where(

            'id',

            $questionId

        )->update([

            'question_text' => trim($text)

        ]);
    }    

    public function updateQuestionHelp($questionId,$help): void
    {
        Question::where(

            'id',

            $questionId

        )->update([

            'help_text' => trim($help)

        ]);
    }    

    public function updateQuestionPlaceholder($questionId,$placeholder): void
    {
        Question::where(

            'id',

            $questionId

        )->update([

            'placeholder' => trim($placeholder)

        ]);
    }    

    public function updateQuestionType(int $questionId,string $type): void
    {
        //dd($type);
        Question::where(
            'id',
            $questionId
        )->update([

            'question_type' => $type

        ]);

        $this->loadSections();
    }    

    public function toggleRequired(int $questionId): void
    {
        $question = Question::findOrFail($questionId);

        $question->update([
            'is_required' => $question->is_required ? 0 : 1
        ]);

        $this->loadSections();

        $this->dispatch('$refresh');
    }
     
    public function addOption(int $questionId): void
    {
        $nextOrder = QuestionOption::where(
            'question_id',
            $questionId
        )->max('sort_order') + 1;

        QuestionOption::create([

            'question_id' => $questionId,

            'option_label' => 'Nouvelle réponse',

            'option_value' => 'nouvelle_reponse',

            'option_score' => 0,

            'sort_order' => $nextOrder,

        ]);

        $this->loadSections();
    }
    
    public function updateOptionLabel(int $optionId,string $label): void
    {
        QuestionOption::where(
            'id',
            $optionId
        )->update([

            'option_label' => trim($label),

            'option_value' => \Illuminate\Support\Str::slug(
                $label,
                '_'
            )

        ]);

        $this->loadSections();
    }
    
    public function updateOptionScore(int $optionId,int $score): void
    {
        QuestionOption::where(
            'id',
            $optionId
        )->update([

            'option_score' => $score

        ]);
    }
    
    public function deleteOption($optionId): void
    {
        QuestionOption::where(

            'id',

            $optionId

        )->delete();

        $this->loadSections();
    }
    
    public function deleteSection(int $sectionId): void
    {
        $section = FormSection::find($sectionId);

        if (!$section) {
            return;
        }

        if ($section->questions()->exists()) {
            return;
        }

        $section->delete();

        $this->loadSections();
    }    
}