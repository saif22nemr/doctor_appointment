<?php

use App\Models\Permission;
use App\Models\Setting;
use App\Models\UserPermission;

function user(){
	return auth()->user();
}
function checkPhones(array $phones){
	if(count($phones) == 0) return false;
	$check = true;
	foreach($phones as $key => $phone):
		if(!isset($phone['number']) or !is_numeric($phone['number']) or strlen($phone['number']) != 11 or !isset($phone['primary']) or !in_array($phone['primary'] , [1,0])):
			return false;
		endif;
		if($phone['primary'] == 1) $check = false;
	endforeach;
	if($check) return false;
	return true;
}

function calucAge($birthday){
	
	return date_diff(date_create($birthday), date_create('today'))->y;

}

// get setting from database
// return string or array
function get_setting($key = null){
	if(!empty($key)){
		if($setting = Setting::where('name' , $key)->first()){
			return $setting->data;
		}else{
			return 'test';
		}
	}else{
		$settings = Setting::all();
		$settingsArray = [];
		foreach($settings as $key => $value){
			$settingsArray[$value->name] = $value->data;
		}
		return $settingsArray;
	}

	
}

// check permission for employee
function has_permission($permission = '' , $role = ''){
	if(!auth()->check()){
		return false;
	}
	$user = auth()->user();
	if($user->group == 1){
		return true;
	}elseif($user->group == 2){
		$permission = Permission::where('key' , $permission)->first();
		if(isset($permission->id) and $user->userPermissions()->where('permission_id' , $permission->id)->where($role , 1)->first()){
			return true;
		}
	}

	return false;
	

	
}
