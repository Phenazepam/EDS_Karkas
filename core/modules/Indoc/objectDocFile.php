<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Indoc;

class ObjectDocFile extends \RedCore\Base\ObjectBase {
	
    public static function Create() {
        return new ObjectDocFile();
	}

	public function __construct() {

		$this->table = "docfile";

		$this->properties = array(

			"id"         => "Number",
			"name"   => "String",
			"directory"   => "String",
			"doc_id"   => "Number",
			"iscurrent"   => "Number",
			"_updated" => "Timestamp",
		    "_deleted" => "Number",
		);

	}

}