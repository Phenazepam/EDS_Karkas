<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Indoc;

class ObjectIndoc extends \RedCore\Base\ObjectBase {
	
    public static function Create() {
	    return new ObjectIndoc();
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
			),
			"_updated" => "Timestamp",
		    "_deleted" => "Number",
		);

	}

}