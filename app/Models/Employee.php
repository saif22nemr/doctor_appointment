<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends User
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->where('group',2);
        });

    }
    public function userPermissions(){
        return $this->hasMany('App\Models\UserPermission' , 'user_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }
}
