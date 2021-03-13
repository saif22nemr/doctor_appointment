<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    use HasFactory;
    protected $table = 'oauth_access_tokens';
    protected $fillable = [
    	'id' , 'user_id' , 'created_at' , 'expire_at'  , 'updated_at'
    ];
    public function activities(){
    	return $this->morphMany('App\Activity', 'activitable');
    }
}
