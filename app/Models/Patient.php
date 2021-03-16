<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'birthday' , 'sex' , 'job' , 'nationality' , 'address' , 'social_status' , 'user_id' , 'application_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User' , 'user_id');
    }
    public function application(){
        return $this->belongsTo('App\Models\Application' , 'application_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

    public function comments(){
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

}
