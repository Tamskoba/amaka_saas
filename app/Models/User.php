<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [

        'first_name',

        'last_name',

        'email',

        'phone',

        'city',

        'country',

        'password',

        'role',

        'is_active',

        'is_deleted',

        'deleted_at',

        'purge_at',

        'must_change_password',

    ];

    protected $hidden = [

        'password',

        'remember_token',

    ];

    protected $casts = [

        'is_active' => 'boolean',

        'is_deleted' => 'boolean',

        'must_change_password' => 'boolean',

        'deleted_at' => 'datetime',

        'purge_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function userForms()
    {
        return $this->hasMany(
            UserForm::class
        );
    }

    public function responseSets()
    {
        return $this->hasMany(
            ResponseSet::class
        );
    }

    public function notifications()
    {
        return $this->hasMany(
            Notification::class
        );
    }

    public function activityLogs()
    {
        return $this->hasMany(
            ActivityLog::class
        );
    }

    public function forms()
    {
        return $this->belongsToMany(

            Form::class,

            'user_forms'

        )->withPivot([

            'is_visible',

            'assigned_at',

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isDeleted(): bool
    {
        return (bool) $this->is_deleted;
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }    
}