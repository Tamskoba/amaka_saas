<?php

namespace App\Livewire\Admin\Trash;

use Livewire\Component;
use App\Models\Form;
use App\Models\User;

class TrashIndex extends Component
{
    public string $tab = 'forms';

    public array $forms = [];

    public array $users = [];

    public function mount(): void
    {
        $this->loadForms();
        $this->loadUsers();
    }

    public function render()
    {
        return view(
            'livewire.admin.trash.trash-index'
        )->layout(
            'components.layouts.admin'
        );
    }

    public function loadForms(): void
    {
        $this->forms = Form::where(
            'is_deleted',
            1
        )
        ->orderByDesc('deleted_at')
        ->get()
        ->toArray();
    }

    public function loadUsers(): void
    {
        $this->users = User::where(
            'is_deleted',
            1
        )
        ->orderByDesc('deleted_at')
        ->get()
        ->toArray();
    }

    public function restoreForm(int $formId): void
    {
        Form::where(
            'id',
            $formId
        )->update([
            'is_deleted' => 0,
            'deleted_at' => null,
            'purge_at' => null,
        ]);

        $this->loadForms();
    }

    public function restoreUser(int $userId): void
    {
        User::where(
            'id',
            $userId
        )->update([
            'is_deleted' => 0,
            'deleted_at' => null,
            'purge_at' => null,
        ]);

        $this->loadUsers();
    }

    public function forceDeleteForm(int $formId): void
    {
        abort_unless(
            auth()->user()?->role === 'admin',
            403,
            'Seul un administrateur peut supprimer définitivement un questionnaire.'
        );

        $form = Form::find($formId);

        if (! $form) {
            return;
        }

        $form->delete();

        $this->loadForms();

        session()->flash(
            'success',
            'Questionnaire supprimé définitivement.'
        );
    }

    public function forceDeleteUser(int $userId): void
    {
        abort_unless(
            auth()->user()?->role === 'admin',
            403,
            'Seul un administrateur peut supprimer définitivement un utilisateur.'
        );

        $user = User::find($userId);

        if (! $user) {
            return;
        }

        $user->delete();

        $this->loadUsers();

        session()->flash(
            'success',
            'Utilisateur supprimé définitivement.'
        );
    }
}