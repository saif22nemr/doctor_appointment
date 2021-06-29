<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'address' ,'position'
    ];

    public function users(){
        return $this->hasMany('App\Models\User' , 'branch_id');
    }

    public function appointments(){
        return $this->hasMany('App\Models\Appointment' , 'branch_id') ;
    }

    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }
}
