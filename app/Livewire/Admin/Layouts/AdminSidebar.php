<?php

namespace App\Livewire\Admin\Layouts;

use Livewire\Component;

class AdminSidebar extends Component
{
    public function render()
    {
        return view(
            'livewire.admin.layouts.admin-sidebar'
        );
    }
}