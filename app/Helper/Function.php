<?php



function checkPhones(array $phones){
	if(count($phones) == 0) return false;
	foreach($phones as $key => $phone):
		if(!isset($phone['number']) or !is_numeric($phone['number']) or strlen($phone['number']) != 11 or !isset($phone['primary']) ):
			return false;
		endif;
	endforeach;

	return true;
}

function calucAge($birthday){
	
	return date_diff(date_create($birthday), date_create('today'))->y;

}
//