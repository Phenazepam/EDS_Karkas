<?php

/**
 * @copyright 2021
 * @author Darkas (mod. Armaturine)
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Infodocs;

class ObjectMaterials extends \RedCore\Base\ObjectBase {
	
	public static function Create() {
	    return new ObjectMaterials();
	}

	public function __construct() {
		
		$this->table = "infodocsmaterials";

		$this->properties = array(
		
			"id"         => "Number",
			"su"      => "String",
			"code"   => "String",
			"group"   => "String",
			"material"   => "String",
			"izm"   => "String",
			"params" => array(
				
			),
			
		    "_deleted" => "Number",
		);

	}



}



?>