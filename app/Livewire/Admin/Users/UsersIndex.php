<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class UsersIndex extends Component
{
    public string $search = '';

    public array $users = [];

    public function mount(): void
    {
        $this->loadUsers();
    }

    public function updatedSearch(): void
    {
        $this->loadUsers();
    }

    public function loadUsers(): void
    {
        $this->users = User::query()
            ->where('is_deleted', 0)

            ->when(
                $this->search,
                function ($query) {

                    $query->where(function ($q) {

                        $q->where(
                            'first_name',
                            'like',
                            '%'.$this->search.'%'
                        )

                        ->orWhere(
                            'last_name',
                            'like',
                            '%'.$this->search.'%'
                        )

                        ->orWhere(
                            'email',
                            'like',
                            '%'.$this->search.'%'
                        );
                    });
                }
            )

            ->orderBy('first_name')
            ->get()
            ->toArray();
    }

    public function deleteUser(
        int $userId
    ): void
    {
        $user = User::find($userId);
        
        if (! $user) {
            return;
        }

        $user->update([

            'is_active' => 0,

            'is_deleted' => 1,

            'deleted_at' => now(),

            'purge_at' => now()->addDays(7),

        ]);

        $this->loadUsers();

        session()->flash(
            'success',
            'Utilisateur placé dans la corbeille.'
        );
    }

    public function render()
    {
        return view('livewire.admin.users.users-index')
        ->layout('components.layouts.admin');
    }
}