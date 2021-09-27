<?php

/**
 * @copyright 2021
 * @author Darkas (mod. Armaturine)
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Infodocs;

class ObjectWorks extends \RedCore\Base\ObjectBase {
	
	public static function Create() {
	    return new ObjectWorks();
	}

	public function __construct() {
		
		$this->table = "infodocsmaterials";

		$this->properties = array(
		
			"id"         => "Number",
			"group"      => "String",
			"name"   => "String",
			"izm"   => "String",
			"krd"   => "String",
			"rnd"   => "String",
			"vldvstk"   => "String",
			"obj1"   => "String",
			"obj2"   => "String",
			"obj3"   => "String",
			"obj4"   => "String",
			"params" => array(
				
			),
			
		    "_deleted" => "Number",
		);

	}


}



?>