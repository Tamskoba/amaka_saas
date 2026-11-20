<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionalSynthesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'content',
        'practitioner_notes',
        'pdf_path',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(
            UserSession::class,
            'session_id'
        );
    }
}