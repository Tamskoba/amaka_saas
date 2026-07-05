<?php

namespace App\Livewire\Dashboard;

use App\Models\ResponseSet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentActivity extends Component
{
    public function render()
    {
        return view(

            'livewire.dashboard.recent-activity',

            [

                'activities' => ResponseSet::with('form')

                    ->where('user_id', Auth::id())

                    ->latest()

                    ->take(5)

                    ->get()

            ]

        );
    }
}