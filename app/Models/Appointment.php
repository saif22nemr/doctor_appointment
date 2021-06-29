<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     *  status => [1 => pending , 2: finished , 0:cancel]
     *  patient_status => [1: new appointment , 2: following]
     *  
     */
    use HasFactory;
    protected $fillable = [
        'date' , 'hour' ,'patient_id' , 'appointment_id'  , 'patient_status' , 'status' ,  'title' ,'note' , 'branch_id'
    ];
    
    public function patient(){
        return $this->belongsTo('App\Models\Patient' , 'patient_id');
    }
    public function appointment(){
        return $this->belongsTo('App\Models\Appointment' , 'appointment_id');
    }
    public function branch(){
        return $this->belongsTo('App\Models\Branch' , 'branch_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }
    public function comments(){
    	return $this->morphMany('App\Models\Comment', 'commentable');
    }

}
