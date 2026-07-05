<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUser extends Component
{
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $country = '';

    public string $password = '';

    public string $role = 'client';

    public bool $is_active = true;

    public function save(): void
    {
        $this->validate([

            'first_name' => 'required|max:100',

            'last_name' => 'required|max:100',

            'email' => 'required|email|unique:users,email',

            'phone' => 'nullable|max:50',

            'city' => 'nullable|max:100',

            'country' => 'nullable|max:100',

            'password' => 'required|min:8',

            'role' => 'required',

        ]);

        User::create([

            'first_name' => $this->first_name,

            'last_name' => $this->last_name,

            'email' => $this->email,

            'phone' => $this->phone,

            'city' => $this->city,

            'country' => $this->country,

            'password' => Hash::make(
                $this->password
            ),

            'role' => $this->role,

            'is_active' => $this->is_active,

            'must_change_password' => true,

            'is_deleted' => false,

        ]);

        session()->flash(
            'success',
            'Utilisateur créé.'
        );

        $this->redirectRoute(
            'admin.users.index'
        );
    }

    public function render()
    {
        return view('livewire.admin.users.create-user')
        ->layout('components.layouts.admin');
    }
}
