<?php

namespace App\Livewire\Sessions;

use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SessionHistory extends Component
{
    public function render()
    {
        $sessions = UserSession::query()
            ->where('user_id', Auth::id())
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
            'livewire.sessions.session-history',
            [
                'sessions' => $sessions,
            ]
        );
    }
}