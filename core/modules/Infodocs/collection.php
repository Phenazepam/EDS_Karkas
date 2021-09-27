<?php
/**
 * @copyright 2021
 * @author Darkas (mod. Armaturine)
 * @copyright REDUIT Co.
 */

namespace RedCore\Infodocs;

use \RedCore\Where as Where;
use RedCore\Session;
use RedCore\Files;
use RedCore\Controller;
use RedCore\Core as Core;
use RedCore\Request;



require_once('sql.php');
require_once('objectMain.php');
require_once('objectAgents.php');
require_once('objectMaterials.php');
require_once('objectWorks.php');
require_once('objectStandarts.php');

class Collection extends \RedCore\Base\Collection { 

	/**
	 * @method \RedCore\Base\Collection setObject()
	 */

	public static function setObject($obj = "oinfodocs") {

		if("oinfodocs" == $obj) {
			self::$object = "oinfodocs";
			self::$sql    = Sql::$sqlInfodocsMain;
			self::$class  = "RedCore\Infodocs\ObjectMain";
			
		} elseif("oinfodocsmaterials" == $obj) {
			
			self::$object = "oinfodocsmaterials";
			self::$sql    = Sql::$sqlInfodocsMaterials;
			self::$class  = "RedCore\Infodocs\ObjectMaterials";
			
		} elseif("oinfodocsagents" == $obj) {
			
			self::$object = "oinfodocsagents";
			self::$sql    = Sql::$sqlInfodocsAgents;
			self::$class  = "RedCore\Infodocs\ObjectAgents";
			
		} elseif("oinfodocsworks" == $obj) {
			
			self::$object = "oinfodocsworks";
			self::$sql    = Sql::$sqlInfodocsWorks;
			self::$class  = "RedCore\Infodocs\ObjectWorks";
			
		} elseif("oinfodocsstandarts" == $obj) {
			
			self::$object = "oinfodocsstandarts";
			self::$sql    = Sql::$sqlInfodocsStandarts;
			self::$class  = "RedCore\Infodocs\ObjectStandarts";
		}
		
		

	}

	/**
	 * @method \RedCore\Base\Collection loadBy()
	 *
	 * @return \RedCore\Users\ObjectBase ObjectBase
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
	
	public static function getHW() {
		return "Hello World";
		
	}

	
}


?>

