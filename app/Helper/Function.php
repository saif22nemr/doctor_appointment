<?php



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
//