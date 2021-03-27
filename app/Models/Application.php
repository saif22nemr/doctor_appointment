<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    // public $timestamps = false;
    
    public function questions(){
        return $this->hasMany('App\Models\ApplicationQuestion' , 'application_id');
    }

    public function patient(){
        return $this->belongsTo('App\Models\Patient' , 'application_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
