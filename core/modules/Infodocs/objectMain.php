<?php

/**
 * @copyright 2021
 * @author Darkas (mod. Armaturine)
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Infodocs;

class ObjectMain extends \RedCore\Base\ObjectBase {
	
	public static function Create() {
	    return new ObjectMain();
	}

	public function __construct() {
		
		$this->table = "infodocs";

		$this->properties = array(
		
			"id"         => "Number",
			"title"      => "String",
			"param_link"   => "String",
			"params" => array(
				
			),
			
		    "_deleted" => "Number",
		);

	}



}



?>