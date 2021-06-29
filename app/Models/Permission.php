<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'key' , 'view', 'create' ,'edit' ,'delete'
    ];

    public function users(){
        return $this->belongsToMany('App\Models\User' , 'user_permission' , 'user_id' , 'permission_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
