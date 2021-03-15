<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;
    protected $table = 'user_permission';
    protected $fillable = [
        'user_id' , 'permission_id' , 'create' , 'edit' , 'delete' , 'view'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User' , 'user_id');
    }

    public function permission(){
        return $this->belongsTo('App\Models\Permission' , 'permission_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }

}
