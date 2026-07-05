<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\FormsIndex;
use App\Livewire\Admin\Forms\AdminFormsIndex;
use App\Livewire\Admin\Forms\FormCreate;
use App\Livewire\Admin\Forms\FormEdit;
use App\Livewire\Admin\Forms\FormImport;
use App\Livewire\Admin\Dashboard\AdminDashboard;
use App\Livewire\Forms\FormRunner;
use App\Livewire\Admin\Forms\DeletedForms;
use App\Livewire\Admin\Users\CreateUser;
use App\Livewire\Admin\Users\EditUser;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    if (Auth::check()) {

        if (auth()->user()->role === 'admin') {

            return redirect()->route('admin.dashboard');

        }

        return redirect()->route('dashboard');
    }

    return view('livewire.welcome.navigation');

})->name('welcome');

//Route::view('/', 'livewire.welcome.navigation');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::view('/dashboard', 'dashboard.index')
    ->middleware(['auth'])
    ->name('dashboard');

Route::get(
    '/questionnaires/{form}',
    \App\Livewire\Forms\FormRunner::class
)->middleware(['auth'])

 ->name('forms.run');

Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return redirect('/login');

})->name('logout');


Route::get(
    '/forms',
    FormsIndex::class
)->middleware(['auth'])
 ->name('forms.index');

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get(
            '/dashboard',
            AdminDashboard::class
        )->name('admin.dashboard');
    });


 Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get(
            '/admin/forms',
            AdminFormsIndex::class
        )->name('admin.forms');
    }
);   

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

Route::get(
    '/forms/{form}',
    FormRunner::class
)->name('forms.run');

Route::get(
    '/admin/trash',
    \App\Livewire\Admin\Trash\TrashIndex::class
)->name('admin.trash.index');

Route::get(
    '/admin/users',
    \App\Livewire\Admin\Users\UsersIndex::class
)->name('admin.users.index');

Route::get(
    '/admin/users/create',
    CreateUser::class
)->name('admin.users.create');

Route::get(
    '/admin/users/{user}/edit',
    EditUser::class
)->name('admin.users.edit');

Route::get(
    '/admin/users/{user}/forms',
    \App\Livewire\Admin\Users\AssignForms::class
)->name('admin.users.forms');