<?php
/**
 *  * @copyright 2017
 *  * @author Darkas
 *  * @copyright REDUIT Co.
 *  */
namespace RedCore\Users;
class ObjectDocTypeRoleMatrix extends \RedCore\Base\ObjectBase {
		
		public static function Create() {
		    return new ObjectDocTypeRoleMatrix();
	}
	
	public function __construct() {
			$this->table = "doctyperolematrix";
			
			$this->properties = array(
				"id"         => "Number",
				"doctype"    => "Number",
				"steps"      => array(
                    "steps" => "String"
					// "draft" => "String",
					// "agreement" => "String",
					// "approval" => "String",
					// "adoption" => "String"
				),
			    "_deleted" => "Number",
		);
	}
	
	// public function getFieldSet($name = "") {
	// 	    $oFS = array();
	// 	    switch ($name) {
	// 	        case 'users-list':
	// 	            $oFS = array(
	// 	               'id' => $this->object->id,
	// 	               'login' => $this->object->login,
	// 	               'f' => $this->object->params->f,
	// 	               'i' => $this->object->params->i,
	// 	               'o' => $this->object->params->o,
	// 				   'role' => $this->object->role,
	// 				   'token_key' => $this->object->token_key,
	//             );
	// 	            break;
	// 	        default:
	// 	            $oFS = array();
	// 	            break;
	//     }
	//     return (object)$oFS;
	// }
}
?>