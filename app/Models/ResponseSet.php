<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'form_id',
        'session_id',
        'status',
        'progress',
        'version_number',
        'completed_at'
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
        return $this->belongsTo(User::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function synthesis()
    {
        return $this->hasOne(Synthesis::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }  

    public function session()
    {
        return $this->belongsTo(UserSession::class,'session_id');
    }    
}