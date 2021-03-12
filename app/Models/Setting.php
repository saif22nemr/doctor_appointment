<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'data'
    ];

    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
