<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Forms\FormsIndex;
use App\Livewire\Forms\FormRunner;
use App\Livewire\Forms\FormResponses;

use App\Livewire\Admin\Forms\AdminFormsIndex;
use App\Livewire\Admin\Forms\FormCreate;
use App\Livewire\Admin\Forms\FormEdit;
use App\Livewire\Admin\Forms\FormImport;

use App\Livewire\Admin\Dashboard\AdminDashboard;

use App\Livewire\Admin\Trash\TrashIndex;

use App\Livewire\Admin\Users\UsersIndex;
use App\Livewire\Admin\Users\CreateUser;
use App\Livewire\Admin\Users\EditUser;
use App\Livewire\Admin\Users\AssignForms;
use App\Livewire\Admin\Users\UserSessionHistory;

use App\Livewire\Sessions\SessionHistory;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| PAGES PUBLIQUES
|--------------------------------------------------------------------------
*/

// Accueil
Route::get('/', function () {

    if (Auth::check()) {

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    return view('livewire.welcome.navigation');

})->name('welcome');


// Authentification
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| PAGES PROTÉGÉES
|--------------------------------------------------------------------------
|
| Toutes les routes situées dans ce groupe nécessitent
| que l'utilisateur soit authentifié.
|
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | TABLEAU DE BORD
    |--------------------------------------------------------------------------
    */

    Route::view('/dashboard', 'dashboard.index')
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROFIL
    |--------------------------------------------------------------------------
    */

    Route::view('/profile', 'profile')
        ->name('profile');


    /*
    |--------------------------------------------------------------------------
    | QUESTIONNAIRES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/forms',
        FormsIndex::class
    )->name('forms.index');


    Route::get(
        '/questionnaires/{form}',
        FormRunner::class
    )->name('forms.run');


    Route::get(
        '/forms/{form}/responses',
        FormResponses::class
    )->name('forms.responses');


    /*
    |--------------------------------------------------------------------------
    | HISTORIQUE DES SESSIONS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/sessions/history',
        SessionHistory::class
    )->name('sessions.history');


    /*
    |--------------------------------------------------------------------------
    | ADMINISTRATION
    |--------------------------------------------------------------------------
    |
    | Pour le moment, ces routes nécessitent seulement d'être connecté.
    | La protection spécifique au rôle "admin" pourra être ajoutée
    | séparément.
    |
    */

    Route::prefix('admin')->group(function () {

        /*
        |----------------------------------------------------------------------
        | Dashboard administrateur
        |----------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            AdminDashboard::class
        )->name('admin.dashboard');


        /*
        |----------------------------------------------------------------------
        | Gestion des questionnaires
        |----------------------------------------------------------------------
        */

        Route::get(
            '/forms',
            AdminFormsIndex::class
        )->name('admin.forms');


        Route::get(
            '/forms/create',
            FormCreate::class
        )->name('admin.forms.create');


        Route::get(
            '/forms/{form}/edit',
            FormEdit::class
        )->name('admin.forms.edit');


        Route::get(
            '/forms/import',
            FormImport::class
        )->name('admin.forms.import');


        /*
        |----------------------------------------------------------------------
        | Corbeille
        |----------------------------------------------------------------------
        */

        Route::get(
            '/trash',
            TrashIndex::class
        )->name('admin.trash.index');


        /*
        |----------------------------------------------------------------------
        | Gestion des utilisateurs
        |----------------------------------------------------------------------
        */

        Route::get(
            '/users',
            UsersIndex::class
        )->name('admin.users.index');


        Route::get(
            '/users/create',
            CreateUser::class
        )->name('admin.users.create');


        Route::get(
            '/users/{user}/edit',
            EditUser::class
        )->name('admin.users.edit');


        Route::get(
            '/users/{user}/forms',
            AssignForms::class
        )->name('admin.users.forms');


        Route::get(
            '/users/{user}/sessions',
            UserSessionHistory::class
        )->name('admin.users.sessions');

    });

});


/*
|--------------------------------------------------------------------------
| DÉCONNEXION
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return redirect('/login');

})->name('logout');