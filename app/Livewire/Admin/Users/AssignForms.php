<?php

namespace App\Livewire\Admin\Users;

use App\Models\Form;
use App\Models\User;
use Livewire\Component;

class AssignForms extends Component
{
    public User $user;

    public array $selectedForms = [];

    public function mount(User $user ): void
    {
        $this->user = $user;

        $this->selectedForms =
            $user->forms()
            ->pluck('forms.id')
            ->toArray();
    }

    public function save(): void
    {
        $syncData = [];

        foreach (
            $this->selectedForms
            as $formId
        ) {

            $syncData[$formId] = [

                'is_visible' => true,

                'assigned_at' => now(),

            ];
        }

        $this->user
            ->forms()
            ->sync($syncData);

        session()->flash(
            'success',
            'Questionnaires assignés.'
        );
    }

    public function render()
    {
        return view(
            'livewire.admin.users.assign-forms',
            [
                'forms' => Form::where(
                    'is_deleted',
                    0
                )
                ->where(
                    'is_active',
                    1
                )
                ->orderBy('title')
                ->get(),
            ]
        )
        ->layout(
            'components.layouts.admin'
        );
    }
}