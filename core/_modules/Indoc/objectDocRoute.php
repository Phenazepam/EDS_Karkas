<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Indoc;

class ObjectDocRoute extends \RedCore\Base\ObjectBase {
	
    public static function Create() {
        return new ObjectDocRoute();
	}

	public function __construct() {

		$this->table = "docroute";

		$this->properties = array(

			"id"         => "Number",
			"doc_id"   => "Number",
			"doc_type"   => "Number",
			"role_id"   => "Number",
			"user_id"   => "Number",
			"step"   => "Number",
			"step_order"   => "Number",
			"iscurrent"   => "Number",
			"_updated" => "Timestamp",
		    "_deleted" => "Number",
		);

	}

}