<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Form;
use App\Models\ResponseSet;
use App\Models\User;
use Livewire\Component;

class AdminDashboard extends Component
{
    public int $users = 0;

    public int $forms = 0;

    public int $responses = 0;

    public int $completed = 0;

    public function mount(): void
    {
        $this->users = User::count();

        $this->forms = Form::count();

        $this->responses = ResponseSet::count();

        $this->completed = ResponseSet::where(
            'status',
            'completed'
        )->count();
    }

    public function render()
    {
        return view(
            'livewire.admin.dashboard.admin-dashboard'
        )

        ->layout('components.layouts.admin');
    }
}