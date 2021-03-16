<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    use HasFactory;
    
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->where('group',1);
        });

    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }
    public function comments(){
    	return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
