<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_set_id',
        'question_id',
        'answer_text',
        'answer_value'
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

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}