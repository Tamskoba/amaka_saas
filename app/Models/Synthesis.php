<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synthesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_set_id',
        'ai_analysis',
        'practitioner_notes',
        'pdf_path'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function responseSet()
    {
        return $this->belongsTo(ResponseSet::class);
    }
}