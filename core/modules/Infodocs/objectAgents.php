<?php

/**
 * @copyright 2021
 * @author Darkas (mod. Armaturine)
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Infodocs;

class ObjectAgents extends \RedCore\Base\ObjectBase {
	
	public static function Create() {
	    return new ObjectAgents();
	}

	public function __construct() {
		
		$this->table = "infodocsagents";

		$this->properties = array(
		
			"id"         => "Number",
			"name"      => "String",
			"inn"   => "String",
			"group_ka"   => "String",
			"material"   => "String",
			"main_worker"   => "String",
			"other"   => "String",
			"params" => array(
				
			),
			
		    "_deleted" => "Number",
		);

	}
}



?>