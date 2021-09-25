<?php
/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Indoc;

use \RedCore\Where as Where;
use RedCore\Files;
use RedCore\Session;
use RedCore\Controller;
use RedCore\Core as Core;
use RedCore\Request;
use RedCore\Users\Collection as Users;

require_once('sql.php');
require_once('objectIndoc.php');
require_once('objectDocTypes.php');
require_once('objectDocLog.php');

class Collection extends \RedCore\Base\Collection { 
    
    
    private static $list = array(
        "0" => "Не выбран",
        
        "1" => "Черновик",
        "2" => "Зарегистрирован",
        "3" => "Предварительное рассмотрение",
        "4" => "Рассмотрение",
        "5" => "Исполнение",
        "6" => "В деле",
        "7" => "В архиве"
    );
     
    private static $routeStatuses = array(
        "1" => "Черновик",
        "2" => "Согласование",
        "3" => "Утверждение",
        "4" => "Принятие",
    );
    
    private static $actionDoc = array(
        "1" => "Черновик создан",
        "2" => "Черновик изменен",
        "3" => "Черновик удален",
        "4" => "Направлен на согласование",
        "5" => "Возврат на доработку",
        "6" => "Согласован",
        "7" => "Направлен на утверждение",
        "8" => "Утвержден",
        "9" => "Принят",
    );


	/**
	 * @method \RedCore\Base\Collection setObject()
	 */

	public static function setObject($obj = "oindoc") {

		if("oindoc" == $obj) {
			self::$object = "oindoc";
			self::$sql    = Sql::$sqlIndoc;
			self::$class  = "RedCore\Indoc\ObjectIndoc";
		}
		elseif ("odoctypes" == $obj){
		    self::$object = "odoctypes";
		    self::$sql    = Sql::$sqlDocTypes;
		    self::$class  = "RedCore\Indoc\ObjectDocTypes";
		}
		elseif ("odoclog" == $obj){
		    self::$object = "odoclog";
		    self::$sql    = Sql::$sqlDocLog;
		    self::$class  = "RedCore\Indoc\ObjectDocLog";
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
	 * @return \RedCore\Base\ObjectBase ObjectBase
	 */
	public static function getList($where = "") {
	    return parent::getList($where);
	}

	public static function store($params = array()) {
	    
	    if("oindoc" == key($params)) {
			Users::setObject("user");
	    	$user_id = Users::getAuthId();

	        if($title = Files::upload("oindoc", "file")) {
	            $params["oindoc"]["params"]["file_title"] = $title;
	        }
	        if(!empty($params["oindoc"]["id"])){
	            self::registerDocLog($params["oindoc"]["id"], "Черновик изменен", "123", $user_id);
	        }
	        else{
	            self::setObject("oindoc");
	            parent::store($params);
	            $lastId = Core::$db->InsertId();
	            self::registerDocLog($lastId, "Черновик создан", "123", $user_id);
	            return;
	        }
			self::setObject("oindoc");
	    }
		parent::store($params);
	}
	
	public static function delete($params = array()){
	    Users::setObject("user");
	    $user_id = Users::getAuthId();
	    
	    if($params["oindoc"]["id"]){
	        self::registerDocLog($params["oindoc"]["id"], "Черновик удален", "123", $user_id);
	    }
	    self::setObject("oindoc");
	
	parent::delete($params);
	}
	
	public static  function getStatuslist() {
	    return self::$list;
	}
	
	public static function getRouteStatuses(){
	    return self::$routeStatuses;
	}
	
	public static function registerDocLog($doc_id = '', $action = '', $comment = '', $user_id = '') {
	    self::setObject("odoclog");
	    
	    $params["odoclog"] = array(
	        'doc_id' => $doc_id,
	        'action' => $action,
	        'comment' => $comment,
	        'user_id' => $user_id,
	    );
	    
        self::store($params);
	}
}
?>