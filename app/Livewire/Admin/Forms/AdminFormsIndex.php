<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Form;
use Livewire\Component;

class AdminFormsIndex extends Component
{

    public function mount(): void
    {
        $this->loadForms();
    }

    public function render()
    {
        return view(

            'livewire.admin.forms.forms-index',
            [
                'forms' => Form::where('is_deleted',0)->paginate(10)
            ]
        )
        ->layout('components.layouts.admin');
    }

    public function updateTitle($formId, $title): void
    {
        $form = Form::find($formId);

        if (!$form) {
            return;
        }

        $form->update([
            'title' => $title
        ]);

        session()->flash(
            'success',
            'Titre mis à jour.'
        );
    }    
    
    public function updateDescription($formId,$description): void
    {
        $form = Form::find($formId);

        if (!$form) {
            return;
        }

        $form->update([
            'description' => $description
        ]);
    }

    public function loadForms(): void
    {
        $this->forms = Form::where('is_deleted',0)
            ->orderByDesc('created_at')
            ->get()
            ->toArray();
    }

    public function toggleStatus(int $formId): void
    {
        $form = Form::find($formId);

        if (!$form) {
            return;
        }

        $form->update([
            'is_active' => !$form->is_active
        ]);

        // Si tu utilises un tableau local :
        $this->loadForms();
    }     
    
    public function deleteForm(int $formId): void
    {
        $form = Form::findOrFail($formId);

        $form->update([
            'is_active' => 0,
            'is_deleted' => 1,
            'deleted_at' => now(),
            'purge_at' => now()->addDays(7),
        ]);

        $this->loadForms();
    }
    
    public function toggleActive(int $formId): void
    {
        $form = Form::findOrFail($formId);

        if ($form->is_deleted) {
            return;
        }

        $form->update([
            'is_active' => ! $form->is_active
        ]);

        $this->loadForms();
    }     
}