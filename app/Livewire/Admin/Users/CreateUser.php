<?php

namespace App\Livewire\Admin\Users;

use App\Mail\UserCreatedMail;
use App\Models\Form;
use App\Models\User;
use App\Models\UserForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreateUser extends Component
{
    /*
    |--------------------------------------------------------------------------
    | ÉTAPE COURANTE
    |--------------------------------------------------------------------------
    */

    public int $step = 1;

    /*
    |--------------------------------------------------------------------------
    | INFORMATIONS UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $country = '';

    public string $role = 'client';

    public bool $is_active = true;

    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR CRÉÉ
    |--------------------------------------------------------------------------
    */

    public ?int $createdUserId = null;

    /*
    |--------------------------------------------------------------------------
    | QUESTIONNAIRES
    |--------------------------------------------------------------------------
    */

    public array $selectedForms = [];

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION
    |--------------------------------------------------------------------------
    */

    public string $notification = 'now';

    /*
    |--------------------------------------------------------------------------
    | ÉTAPE 1
    |--------------------------------------------------------------------------
    */

    public function createUser(): void
    {
        // Si l'utilisateur a déjà été créé,
        // on revient simplement à l'étape suivante.
        if ($this->createdUserId) {
            $this->step = 2;
            return;
        }

        $this->validate(
            [
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'phone' => 'nullable|max:50',
                'city' => 'nullable|max:100',
                'country' => 'nullable|max:100',
                'role' => 'required|in:client,micronutritionist,admin',
                'is_active' => 'boolean',
            ],
            [
                'email.unique' => 'Cette adresse email est déjà utilisée. Veuillez utiliser une autre adresse email.',
                'email.required' => 'L’adresse email est obligatoire.',
                'email.email' => 'Veuillez saisir une adresse email valide.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Génération du mot de passe temporaire
        |--------------------------------------------------------------------------
        */

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
        | Conservation de l'utilisateur créé
        |--------------------------------------------------------------------------
        */

        $this->createdUserId = $user->id;

        /*
        |--------------------------------------------------------------------------
        | Conservation du mot de passe temporaire
        |--------------------------------------------------------------------------
        */

        session()->put(
            'create_user.temporary_password',
            encrypt($temporaryPassword)
        );

        /*
        |--------------------------------------------------------------------------
        | Étape suivante
        |--------------------------------------------------------------------------
        */

        $this->step = 2;
    }

    /*
    |--------------------------------------------------------------------------
    | ÉTAPE 2
    |--------------------------------------------------------------------------
    */

    public function assignForms(): void
    {
        if (!$this->createdUserId) {
            return;
        }

        $user = User::findOrFail(
            $this->createdUserId
        );

        /*
        |--------------------------------------------------------------------------
        | Suppression des anciennes assignations
        |--------------------------------------------------------------------------
        */

        UserForm::where(
            'user_id',
            $user->id
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | Création des nouvelles assignations
        |--------------------------------------------------------------------------
        */

        foreach ($this->selectedForms as $formId) {

            UserForm::create([

                'user_id' => $user->id,

                'form_id' => (int) $formId,

                'status' => 'not_started',

                'progress_percentage' => 0,

                'assigned_by' => Auth::id(),

                'assigned_at' => now(),

                'is_visible' => true,

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Passage à l'étape 3
        |--------------------------------------------------------------------------
        */

        $this->step = 3;
    }

    /*
    |--------------------------------------------------------------------------
    | ÉTAPE 3
    |--------------------------------------------------------------------------
    */

    public function finish(): void
    {
        if (!$this->createdUserId) {
            return;
        }

        $user = User::findOrFail(
            $this->createdUserId
        );

        /*
        |--------------------------------------------------------------------------
        | Envoi de l'email
        |--------------------------------------------------------------------------
        */

        if ($this->notification === 'now') {

            $encryptedPassword = session(
                'create_user.temporary_password'
            );

            if ($encryptedPassword) {

                $temporaryPassword = decrypt(
                    $encryptedPassword
                );

                Mail::to($user->email)
                    ->send(
                        new UserCreatedMail(
                            $user,
                            $temporaryPassword
                        )
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Nettoyage du mot de passe temporaire
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'create_user.temporary_password'
        );

        /*
        |--------------------------------------------------------------------------
        | Confirmation
        |--------------------------------------------------------------------------
        */

        if ($this->notification === 'now') {

            session()->flash(
                'success',
                'Utilisateur créé, questionnaires assignés et identifiants envoyés par email.'
            );

        } else {

            session()->flash(
                'success',
                'Utilisateur créé et questionnaires assignés. L’email sera envoyé ultérieurement.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Retour à la liste
        |--------------------------------------------------------------------------
        */

        $this->redirectRoute(
            'admin.users.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RETOUR ÉTAPE 1
    |--------------------------------------------------------------------------
    */

    public function previousStep(): void
    {
        if ($this->step > 1) {

            $this->step--;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ANNULATION
    |--------------------------------------------------------------------------
    */

    public function cancel(): void
    {
        /*
        | Si l'utilisateur a déjà été créé et que l'administrateur
        | abandonne le workflow, on supprime le compte créé.
        */

        if ($this->createdUserId) {

            User::where(
                'id',
                $this->createdUserId
            )->delete();
        }

        session()->forget(
            'create_user.temporary_password'
        );

        $this->redirectRoute(
            'admin.users.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | QUESTIONNAIRES DISPONIBLES
    |--------------------------------------------------------------------------
    */

    public function getFormsProperty()
    {
        return Form::query()

            ->where('is_active', true)

            ->where('is_deleted', false)

            ->orderBy('title')

            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | MOT DE PASSE TEMPORAIRE
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.admin.users.create-user'
        )->layout(
            'components.layouts.admin'
        );
    }
}