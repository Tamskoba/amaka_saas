<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditUser extends Component
{
    public User $user;

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $country = '';

    public string $role = 'client';

    public bool $is_active = true;

    public string $password = '';

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->first_name = $user->first_name ?? '';

        $this->last_name = $user->last_name ?? '';

        $this->email = $user->email ?? '';

        $this->phone = $user->phone ?? '';

        $this->city = $user->city ?? '';

        $this->country = $user->country ?? '';

        $this->role = $user->role ?? 'client';

        $this->is_active = (bool) $user->is_active;
    }

    protected function rules(): array
    {
        return [

            'first_name' => [
                'required',
                'max:100'
            ],

            'last_name' => [
                'required',
                'max:100'
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email,' . $this->user->id,
            ],

            'phone' => [
                'nullable',
                'max:50'
            ],

            'city' => [
                'nullable',
                'max:100'
            ],

            'country' => [
                'nullable',
                'max:100'
            ],

            'role' => [
                'required',
                'in:client,micronutritionist,admin'
            ],

        ];
    }

    public function save(): void
    {
        //dd('save appelé');
        $this->validate();

        $data = [

            'first_name' => $this->first_name,

            'last_name' => $this->last_name,

            'email' => $this->email,

            'phone' => $this->phone,

            'city' => $this->city,

            'country' => $this->country,

            'role' => $this->role,

            'is_active' => $this->is_active,

        ];

        if (!empty($this->password)) {

            $data['password'] = Hash::make(
                $this->password
            );

            $data['must_change_password'] = true;
        }

        $this->user->update($data);

        session()->flash(
            'success',
            'Utilisateur mis à jour avec succès.'
        );

        $this->redirectRoute(
            'admin.users.index'
        );        
    }

    public function render()
    {
        return view('livewire.admin.users.edit-user')
        ->layout('components.layouts.admin');
    }
}