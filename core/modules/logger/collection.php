<?php
/**
 *  * @copyright 2019
 *  * @author Darkas
 *  * @copyright REDUIT Co.
 *  */
namespace RedCore\Logger;
use \RedCore\Controller as Controller;
use \RedCore\Core as Core;
use \RedCore\Where as Where;
use RedCore\Session;
require_once('sql.php');
require_once('object.php');
class Collection extends \RedCore\Base\Collection {     

    	public static function setObject($obj = "log") {
    		if("log" == $obj) {
    		    static::$object = "log";
		    static::$sql    = Sql::$sqlLogs;
		    static::$class  = "RedCore\Logger\ObjectBase";
		}
	}

	/**
	 * @method \RedCore\Base\Collection loadBy()
	 * 
	 * @return \RedCore\Logger\ObjectBase Object
	 */
	public static function loadBy($params = array()) {
    	    return parent::loadBy($params);
    }

    /**
     * @method \RedCore\Base\Collection getList()
     *
     * @return array<\RedCore\Logger\ObjectBase> Object
     */
    public static function getList($where = "") {
            return parent::getList($where);
    }

    public static function registerEvent($type = '', $action = '', $message = '', $user_id = '') {
            self::setObject("log");

        $params["log"] = array(
                'e_type' => $type,
            'action' => $action,
            'message' => $message,
            'user_id' => $user_id
        );

        self::store($params);
    }
}

?>