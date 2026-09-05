<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Models\UserSession;
use Livewire\Component;

class UserSessionHistory extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render()
    {
       //@dd($this->user);
        $sessions = UserSession::query()
            ->where('user_id', $this->user->id)
            ->with([
                'responseSets.form',
            ])
            ->withCount([
                'responseSets as completed_forms_count' => function ($query) {
                    $query->where('status', 'completed');
                },
            ])
            ->orderByDesc('session_number')
            ->get();

        return view(
            'livewire.admin.users.user-session-history',
            [
                'sessions' => $sessions,
            ]
        )->layout('components.layouts.admin');
    }
}