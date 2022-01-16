<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */
 
namespace RedCore\Indoc;

class objectRecognition extends \RedCore\Base\ObjectBase {
	
    public static function Create() {
        return new objectRecognition();
	}

	public function __construct() {

		$this->table = "recognition";

		$this->properties = array(

			"id"         => "Number",
			"doc_id"   => "Number",
			"file_id"   => "Number",
			"recognized_file_id"   => "Number",
			"rec_text"   => "String",
            "params" => "String",
			"_updated"   => "Timestamp",
			"_deleted"   => "Number",
		);

	}

}