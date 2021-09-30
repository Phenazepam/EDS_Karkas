<?php

/**
 * @copyright 2021
 * @author Darkas (mod. Armaturine)
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Infodocs;

class ObjectStandarts extends \RedCore\Base\ObjectBase {
	
	public static function Create() {
	    return new ObjectStandarts();
	}

	public function __construct() {
		
		$this->table = "infodocsstandarts";

		$this->properties = array(
		
			"id"         => "Number",
			"name"   => "String",
			"izm"   => "String",
			"ku"   => "String",
			"bp"   => "String",
			"fp"   => "String",
			"rostverk"   => "String",
			"walls"   => "String",
			"kolon"   => "String",
			"perekryt"   => "String",
			"balki"   => "String",
			"rigel"   => "String",
			"smallconstr"   => "String",
			"decor"   => "String",
			"pryamlest"   => "String",
			"krivlest"   => "String",
			"params" => array(
				
			),
			
		    "_deleted" => "Number",
		);

	}
	public function getId($name = "") {
		    $oFS = array();
		    
		    switch ($name) {
		        case 'standarts':
		            $oFS = array(
		               'id' => $this->object->id,
	            );
		            break;
		        default:
		            $oFS = array();
		            break;
	    }
	    
	    return (object)$oFS;
	}

}



?>

