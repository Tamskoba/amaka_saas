<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

class DeletedUsers extends Component
{

    public array $users = [];

    public function mount(): void
    {
        $this->loadUsers();
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

    public function restore(int $userId): void
    {
        User::findOrFail($userId)
            ->update([
                'is_active' => 1,
                'is_deleted' => 0,
                'deleted_at' => null,
                'purge_at' => null,
            ]);

        $this->loadUsers();
    }

    public function forceDelete(int $userId): void
    {
        User::findOrFail($userId)
            ->delete();

        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.admin.users.deleted-users')
        ->layout('components.layouts.admin');        
    }
}
