<?php

/**
 * @Author: SUPERMAN
 * @Date:   2022-06-14 14:54:43
 * @Last Modified by:   SUPERMAN
 * @Last Modified time: 2022-06-22 12:09:05
 */

function getStatusMessage($status = 0){
	$statuses =[
		'0' => '',
		'1' => 'Duplicate Email',
		'2' => 'Empty Or Wrong In Form',
		'3' => 'Username Or Password Id incorrect',
		'5' => 'User Is not Exist',
	];
	if (array_key_exists("$status",$statuses)){
		echo "<blockquote style='color: red;'>". $statuses[$status] ."</blockquote>";
  	}
  	else{
  		return false;
  	}
}

function isCheckedCheckBox($inputName, $value){
	if (isset($_REQUEST[$inputName]) && is_array($_REQUEST[$inputName]) && in_array($value, $_REQUEST[$inputName])) {
		echo " checked";
	}
}


function selectItem($options){
	foreach ($options as $option) {
		printf("<option value='%s'>%s</option>\n", ucwords($option), ucwords($option));
	}
}

