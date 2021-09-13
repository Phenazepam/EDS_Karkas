<?php
/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\DocTypes;

use \RedCore\Where as Where;
use RedCore\Files;
use RedCore\Session;
use RedCore\Controller;
use RedCore\Core as Core;
use RedCore\Request;


require_once('sql.php');
require_once('object.php');

class Collection extends \RedCore\Base\Collection { 
    

	/**
	 * @method \RedCore\Base\Collection setObject()
	 */

	public static function setObject($obj = "odoctypes") {

		if("odoctypes" == $obj) {
			self::$object = "odoctypes";
			self::$sql    = Sql::$sqlDocTypes;
			self::$class  = "RedCore\DocTypes\ObjectDocTypes";
		}

	}

	/**
	 * @method \RedCore\Base\Collection loadBy()
	 *
	 * @return \RedCore\Indoc\ObjectIndoc ObjectIndoc
	 */
	public static function loadBy($params = array()) {
	    return parent::loadBy($params);
	}

	/**
	 * @method \RedCore\Base\Collection getList()
	 *
	 * @return \RedCore\Users\ObjectBase ObjectBase
	 */
	public static function getList($where = "") {
	    return parent::getList($where);
	}
	
	public static function store($params = array()) {
	    parent::store($params);
	}
	
}
?>