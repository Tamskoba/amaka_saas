<?php

namespace App\Livewire\Dashboard;

use App\Models\ResponseSet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardStats extends Component
{
    public int $completed = 0;

    public int $inProgress = 0;

    public int $remaining = 0;

    public function mount(): void
    {
        $userId = Auth::id();

        $this->completed = ResponseSet::where(
            'user_id',
            $userId
        )

        ->where('status', 'completed')

        ->count();

        $this->inProgress = ResponseSet::where(
            'user_id',
            $userId
        )

        ->where('status', 'progress')

        ->count();

        $this->remaining = ResponseSet::where(
            'user_id',
            $userId
        )

        ->where('status', 'new')

        ->count();
    }

    public function render()
    {
        return view(
            'livewire.dashboard.dashboard-stats'
        );
    }
}