<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choose extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'question_id' , 'choose'
    ];

    public function question(){
        return $this->belongsTo('App\Models\Question' , 'question_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
