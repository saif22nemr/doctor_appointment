<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'status',
        'group',
        'branch_id',
        'api_token',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function phones(){
        return $this->hasMany('App\Models\Phone' , 'user_id');
    }
    public function patient(){
        return $this->hasOne('App\Models\Patient' , 'user_id');
    }
    public function permission(){
        return $this->hasMany('App\Models\UserPermission' , 'user_id');
    }
    public function OauthAccessToken(){
        return $this->hasMany('App\Models\OauthAccessToken' , 'user_id');
    }
    public function activities(){
    	return $this->morphMany('App\Models\Activity', 'activitable');
    }
    public function branch(){
        return $this->belongsTo('App\Models\Branch' , 'branch_id');
    }
    public function userPermissions(){
        return $this->hasMany('App\Models\UserPermission' , 'user_id');
    }
}
