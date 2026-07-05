<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'is_active',
        'is_deleted',
        'deleted_at',
        'purge_at',
        'has_scoring',
        'json_definition'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_scoring' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

public function sections()
{
    return $this->hasMany(
        FormSection::class,
        'form_id'
    );
}

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function userForms()
    {
        return $this->hasMany(UserForm::class);
    }

    public function responseSets()
    {
        return $this->hasMany(ResponseSet::class);
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_forms'
        )
        ->withPivot([
            'is_visible',
            'assigned_at'
        ]);
    }
}