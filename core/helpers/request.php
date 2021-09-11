<?php
/**
 * @copyright 2016
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore;

class Request {
	public static function vars($var = false) {
		if($var) {
		    return $_REQUEST[(string)$var];
		}
	}
	
}