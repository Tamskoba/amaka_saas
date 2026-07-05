<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    protected $table = 'user_sessions';

    protected $fillable = [

        'user_id',

        'session_number',

        'status',

        'completed_at',

    ];

    protected $casts = [

        'completed_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function responseSets()
    {
        return $this->hasMany(
            ResponseSet::class,
            'session_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}