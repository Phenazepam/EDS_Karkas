<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Indoc;

class ObjectDocTypes extends \RedCore\Base\ObjectBase {
	
    public static function Create() {
        return new ObjectDocTypes();
	}

	public function __construct() {

		$this->table = "doctypes";

		$this->properties = array(

			"id"         => "Number",
			"title"   => "String",
			"_updated" => "Timestamp",
		    "_deleted" => "Number",
		);

	}

}