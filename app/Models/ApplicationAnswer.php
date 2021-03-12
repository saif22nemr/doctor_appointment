<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationAnswer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'question_id' , 'answer'
    ];

    public function question(){
        return $this->belongsTo('App\Models\ApplicationQuestion' , 'question_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
