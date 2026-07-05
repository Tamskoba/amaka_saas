<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'force_password_change',
        'notify_when_all_forms_completed',
        'auto_generate_password'
    ];

    protected $casts = [
        'force_password_change' => 'boolean',
        'notify_when_all_forms_completed' => 'boolean',
        'auto_generate_password' => 'boolean',
    ];
}