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



require_once('sql.php');
require_once('object.php');

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

	/**
	 * @method \RedCore\Base\Collection setObject()
	 */

	public static function setObject($obj = "oindoc") {

		if("oindoc" == $obj) {
			self::$object = "oindoc";
			self::$sql    = Sql::$sqlIndoc;
			self::$class  = "RedCore\Indoc\ObjectIndoc";
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
	    if("oindoc" == key($params)) {
	        if($title = Files::upload("oindoc", "file")) {
	            $params["oindoc"]["params"]["file_title"] = $title;
	        }
	    }
		parent::store($params);
		
	}
	
	public static  function getStatuslist() {
	    return self::$list;
	}
	
}
?>