<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\DocTypes;

class ObjectDocTypes extends \RedCore\Base\ObjectBase {
	
    public static function Create() {
        return new ObjectDocTypes();
	}

	public function __construct() {

		$this->table = "doc_types";

		$this->properties = array(

			"id"         => "Number",
			"title"   => "String",
			"_updated" => "Timestamp",
		    "_deleted" => "Number",
		);

	}

}