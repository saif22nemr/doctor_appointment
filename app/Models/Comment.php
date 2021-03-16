<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id' , 'commentable_type' , 'commentable_id' , 'message'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }
}
