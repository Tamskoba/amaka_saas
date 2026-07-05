<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'parent_id',
        'title',
        'description',
        'sort_order'
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

    public function parent()
    {
        return $this->belongsTo(FormSection::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(FormSection::class, 'parent_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'section_id');
    }

}