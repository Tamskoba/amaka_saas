<?php

namespace App\Livewire\Admin\Users;

use App\Mail\UserCreatedMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateUser extends Component
{
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $country = '';

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

            'role' => 'required',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Génération du mot de passe temporaire
        |--------------------------------------------------------------------------
        */

        // $temporaryPassword = Str::password(
        //     length: 12,
        //     letters: true,
        //     numbers: true,
        //     symbols: true,
        //     spaces: false
        // );

        $temporaryPassword = $this->generateTemporaryPassword();

        /*
        |--------------------------------------------------------------------------
        | Création de l'utilisateur
        |--------------------------------------------------------------------------
        */

        $user = User::create([

            'first_name' => $this->first_name,

            'last_name' => $this->last_name,

            'email' => $this->email,

            'phone' => $this->phone,

            'city' => $this->city,

            'country' => $this->country,

            'password' => Hash::make(
                $temporaryPassword
            ),

            'role' => $this->role,

            'is_active' => $this->is_active,

            'must_change_password' => true,

            'is_deleted' => false,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Envoi des identifiants par email
        |--------------------------------------------------------------------------
        */

        Mail::to($user->email)
            ->send(
                new UserCreatedMail(
                    $user,
                    $temporaryPassword
                )
            );

        /*
        |--------------------------------------------------------------------------
        | Confirmation
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'success',
            'Utilisateur créé et identifiants envoyés par email.'
        );

        $this->redirectRoute(
            'admin.users.index'
        );
    }

    private function generateTemporaryPassword(): string
    {
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$&';

        $password = [
            $letters[random_int(0, strlen($letters) - 1)],
            $letters[random_int(0, strlen($letters) - 1)],
            $letters[random_int(0, strlen($letters) - 1)],
            $letters[random_int(0, strlen($letters) - 1)],
            $letters[random_int(0, strlen($letters) - 1)],
            $letters[random_int(0, strlen($letters) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $symbols[random_int(0, strlen($symbols) - 1)],
            $symbols[random_int(0, strlen($symbols) - 1)],
            $letters[random_int(0, strlen($letters) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
        ];

        shuffle($password);

        return implode('', $password);
    }

    public function render()
    {
        return view('livewire.admin.users.create-user')
            ->layout('components.layouts.admin');
    }
}