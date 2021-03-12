<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'date' , 'hour' ,'patient_id' , 'appointment_id'  , 'patient_status' , 'status'
    ];
    
    public function patient(){
        return $this->belongsTo('App\Models\Patient' , 'patient_id');
    }
    public function appointment(){
        return $this->belongsTo('App\Models\Appointment' , 'appointment_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
