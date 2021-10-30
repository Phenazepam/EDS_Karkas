<?php

/*
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
			"reg_number" => "Number",
		    "reg_date"   => "Date",
			"status"  => "Number",
		    "user_id" => "Number",
			"params" => array(
				"file_title" => "String",
			    "doctypes" => "Number",
			),
			"_updated" => "Timestamp",
		    "_deleted" => "Number",
		);

	}

}