<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id' , 'question_id'  , 'question' , 'reason' , 
    ];

    public function application(){
        return $this->belongsTo('App\Models\Applications' , 'application_id');
    }
    public function question(){
        return $this->belongsTo('App\Models\Question' , 'question_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
