<?php

/**
 * @copyright 2016
 * @author Darkas
 * @copyright REDUIT Co.
*/

namespace RedCore;

class Validator {

	public static function Number($value = '') {
		return (int)$value;
	}
	
	public static function Float($value = '') {
		return (float)$value;
	}
	
	public static function String($value = '') {
	    return (string)$value;
	}
	
	public static function Mixed($value = '') {
	    return $value;
	}
	
	public static function Timestamp($value = '') {
		return date('Y-m-d H-i-s'); //
	}

	public static function Date($value = '') {
		//var_dump($value);
		return date('Y-m-d', strtotime($value)); // H-i-s
	}
	
	public static function DbString($value = '') {
		return Core::$db->quote($value);
	}
}

?>
