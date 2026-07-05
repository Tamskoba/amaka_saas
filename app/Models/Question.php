<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'section_id',
        'question_text',
        'question_type',
        'placeholder',
        'help_text',
        'is_required',
        'sort_order',
        'scoring_group',
        'scoring_weight',
        'conditional_logic'
    ];

    protected $casts = [
        'conditional_logic' => 'array',
        'is_required' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function section()
    {
        return $this->belongsTo(FormSection::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function options()
    {
        return $this->hasMany(

            QuestionOption::class

        )
        ->orderBy('sort_order');
    }    
}