<?php
/**
 *  * @copyright 2019
 *  * @author Darkas
 *  * @copyright REDUIT Co.
 *  */
namespace RedCore\Logger;

class ObjectBase extends \RedCore\Base\ObjectBase {

		public static function Create() {
		    return new ObjectBase();
	}

	public function __construct() {
			$this->table = "log";

			$this->properties = array(
				"id"         => "Number",
			    "e_type"     => "String",
			    "action"     => "String",
			    "message"    => "String",
			    "user_id"    => "Number",
				"params"     => array()
		);
	}

	public function getFieldSet($name = "") {
		    $oView = array();

		    switch ($name) {
		        case 'list':
		            $oView = array();
		            break;
		        default:
		            $oView = array();
		            break;
	    }
	    return (object)$oView;
	}

	public function getId() {
		    return $this->object->id;
	}

	public function getType() {
		    return $this->object->e_type;
	}

	public function getAction() {
		    return $this->object->action;
	}

	public function getMessage() {
		    return $this->object->message;
	}

	public function getUserId() {
		    return $this->object->user_id;
	}

	public function getUpdated() {
		    return $this->object->_updated;
	}

}
?>