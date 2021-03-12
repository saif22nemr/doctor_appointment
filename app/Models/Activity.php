<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'   , 'user_id' , 'activitable_type' , 'activitable_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User' , 'user_id');
    }
}
