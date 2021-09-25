<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Search;

class ObjectSearch extends \RedCore\Base\ObjectBase {
	public static function Create() {
	    return new ObjectSearch();
	}

	public function __construct() {

		$this->table = "document";

		$this->properties = array(
		    "id"         => "Number",
		    "name_doc"   => "String",
		    "reg_number" => "String",
		    "reg_date"   => "Timestamp",
		    "resolution" => "String",
		    "params" => array(
		        "file_title" => "String",
		        "status_id"  => "Number",
		        "doctypes" => "Number",
		    ),
		    "_updated" => "Timestamp",
		    "_deleted" => "Number",
			
			
		);

	}

	

	public function getFieldSet($name = "") {

	    $oFS = array();

	    

	    switch ($name) {

	        case 'budgetcalc-list':
	            $oFS = array(
	               'id' => $this->object->id,
	               'liter_id' => $this->object->liter_id,
				   'title' => $this->object->title,
				   'type' => $this->object->type,
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