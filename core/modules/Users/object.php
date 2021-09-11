<?php



/**

 * @copyright 2017

 * @author Darkas

 * @copyright REDUIT Co.

 */



namespace RedCore\Users;



class ObjectBase extends \RedCore\Base\ObjectBase {

	

	public static function Create() {

	    return new ObjectBase();

	}

	

	public function __construct() {

		$this->table = "users";

		

		$this->properties = array(

			"id"         => "Number",
			"login"      => "String",
			"password"   => "String",
			"role"       => "Number",
			"device_key" => "String",
			"token_key"  => "String",
			"params"     => array(
				"f" => "String",
				"i" => "String",
			),

		    "_deleted" => "Number",

		);

	}

	

	public function getFieldSet($name = "") {

	    $oFS = array();

	    

	    switch ($name) {

	        case 'users-list':

	            $oFS = array(

	               'id' => $this->object->id,

	               'login' => $this->object->login,

	               'f' => $this->object->params->f,

	               'i' => $this->object->params->i,

	               'o' => $this->object->params->o,

				   'role' => $this->object->role,

				   'token_key' => $this->object->token_key,

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