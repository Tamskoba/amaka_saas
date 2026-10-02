<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
                'max:100',
            ],

            'last_name' => [
                'required',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')
                    ->ignore($this->user->id),
            ],

            'phone' => [
                'nullable',
                'max:50',
            ],

            'city' => [
                'nullable',
                'max:100',
            ],

            'country' => [
                'nullable',
                'max:100',
            ],

            'role' => [
                'required',
                'in:client,micronutritionist,admin',
            ],

        ];
    }

    protected function messages(): array
    {
        return [

            'first_name.required' =>
                'Le prénom est obligatoire.',

            'first_name.max' =>
                'Le prénom ne peut pas dépasser 100 caractères.',

            'last_name.required' =>
                'Le nom est obligatoire.',

            'last_name.max' =>
                'Le nom ne peut pas dépasser 100 caractères.',

            'email.required' =>
                'L’adresse email est obligatoire.',

            'email.email' =>
                'Veuillez saisir une adresse email valide.',

            'email.max' =>
                'L’adresse email ne peut pas dépasser 150 caractères.',

            'email.unique' =>
                'Cette adresse email est déjà utilisée. Veuillez utiliser une autre adresse email.',

            'phone.max' =>
                'Le numéro de téléphone ne peut pas dépasser 50 caractères.',

            'city.max' =>
                'La ville ne peut pas dépasser 100 caractères.',

            'country.max' =>
                'Le pays ne peut pas dépasser 100 caractères.',

            'role.required' =>
                'Le rôle est obligatoire.',

            'role.in' =>
                'Le rôle sélectionné n’est pas valide.',
        ];
    }

    public function save(): void
    {
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

    public function cancel(): void
    {
        $this->redirectRoute(
            'admin.users.index'
        );
    }

    public function render()
    {
        return view(
            'livewire.admin.users.edit-user'
        )->layout(
            'components.layouts.admin'
        );
    }
}