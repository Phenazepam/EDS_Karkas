<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Indoc;

class objectRelatedDocs extends \RedCore\Base\ObjectBase {
	
    public static function Create() {
        return new objectRelatedDocs();
	}

	public function __construct() {

		$this->table = "relateddocs";

		$this->properties = array(

			"id"         => "Number",
			"doc_id"   => "Number",
			"relateddoc_id"   => "Number",
			"_updated"   => "Timestamp",
			"_deleted"   => "Number",
		);

	}

}