<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $fillable = [

        'question_id',

        'option_label',

        'option_value',

        'option_score',

        'sort_order',

    ];

    public function question()
    {
        return $this->belongsTo(
            Question::class
        );
    }
}