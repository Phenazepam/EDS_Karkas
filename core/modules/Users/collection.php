<?php

/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Users;

use \RedCore\Logger\Collection as Logger;
use \RedCore\Users\Collection as Users;
use \RedCore\Controller as Controller;
use RedCore\Validator as Vladik;
use \RedCore\Core as Core;
use \RedCore\Where as Where;
use RedCore\Session;

require_once('sql.php');
require_once('objectUser.php');
require_once('objectAccessMatrix.php');
require_once('objectDocTypeRoleMatrix.php');

class Collection extends \RedCore\Base\Collection { 
	
	public static $roles = array(
		"0" => "Не выбрана",
		
	    "1" => "Система",
		"2" => "Администратор",
	    "3" => "Гость",
	    "4" => "Специалист ИТР",
	    "5" => "Нач. отдела ИТР",
	    "6" => "Сотрудник юр. отдела",
		"7" => "Сотрудник отдела кадров",
		"8" => "Специалист ПТО",
		"9" => "Нач. отдела ПТО",
		"10" => "Специалист ПЭО",
		"11" => "Нач. отдела ПЭО",
		"12" => "Нарыжный Е.В.",
		"13" => "Главный механик",
		"14" => "Специалист ОМТС",
		"15" => "Кущенко Н.В.",
		"16" => "Икономиди С.Ю.",
		"17" => "Специалист бухгалтерии",
		"18" => "Нач. отдела бухгалтерии",
		"19" => "Руководитель",
	);

	protected static $mainPageModules = array();
	
	/**
	 * @method \RedCore\Base\Collection setObject()
	 */
	public static function setObject($obj = "user") {
		if("user" == $obj) {
			self::$object = "user";
			self::$sql    = Sql::$sqlUsers;
			self::$class  = "RedCore\Users\ObjectUser";
			self::$mainPageModules = include(__DIR__.'/../../view/desktop/MainPageModules.php');
		}
		elseif("accessmatrix" == $obj) {
			self::$object = "accessmatrix";
			self::$sql    = Sql::$sqlAccessMatrix;
			self::$class  = "RedCore\Users\ObjectAccessMatrix";
		}
		elseif("doctyperolematrix" == $obj) {
			self::$object = "doctyperolematrix";
			self::$sql    = Sql::$sqlDocTypeRoleMatrix;
			self::$class  = "RedCore\Users\objectDocTypeRoleMatrix";
		}
	}
	
	/**
	 * @method \RedCore\Base\Collection loadBy()
	 *
	 * @return \RedCore\Users\ObjectBase Object
	 */
	public static function loadBy($params = array()) {
	    return parent::loadBy($params);
	}
	
	/**
	 * @method \RedCore\Base\Collection loadBy()
	 *
	 * @return \RedCore\Users\ObjectBase Object
	 */
	public static function getList($where = "") {
	    return parent::getList($where);
	}

	/**
	 * @method \RedCore\Base\Collection Auth()
	 */
	public static function Auth($params = array()) {
	    $obj = self::$object;
	    
	    $lb_params = array(
	        "login"    => $params[$obj]["login"],
	        "password" => $params[$obj]["password"],
	    );
	    
	    if($$obj = self::loadBy($lb_params)) {
	        $$obj->object->device_key = get_ip();
	        $$obj->object->token_key = md5($$obj->object->login . $$obj->object->password . $$obj->object->device_key);
	        $$obj->store();
	        Session::set("controller_user_auth", $$obj->object->token_key);
	        
	        Logger::registerEvent("SECURITY", "Auth", "successful", $$obj->object->id);
	    }
	    else {
	        Logger::registerEvent("SECURITY", "Auth", "unsuccessful: wrong login or password", $$obj->object->id);
	        
	        Session::delete("controller_user_auth");
	        return false;
	    }
	}
	
	public static function logout() {
	    Logger::registerEvent("SECURITY", "Logout", "successful", self::getAuthId());
	    Session::delete("controller_user_auth");
	    Controller::Redirect("/");
	}
	
	public static function isAuth() {
	    $obj = self::$object;
	    
	    if($token_key = Session::get("controller_user_auth")) {
	        $lb_params = array(
	            "token_key" => $token_key,
	        );
	        
	        if($$obj = self::loadBy($lb_params)) {
	            return true;
	        }
	    }
	    
	    return false;
	}
	
	public static function getAuthToken() {
	    if($token_key = Session::get("controller_user_auth")) {
	        return $token_key;
	    }
	    
	    return false;
	}
	
	public static function getAuthRole() {
	    $obj = self::$object;
	    
	    if($token_key = Session::get("controller_user_auth")) {
	        $lb_params = array(
	            "token_key" => $token_key,
	        );

	        if($$obj = self::loadBy($lb_params)) {
	            
	            return $$obj->object->role;
	        }
	    }
	    
	    return false;
	}
	
	public static function getAuthId() {
	    $obj = self::$object;
	    
	    if($token_key = Session::get("controller_user_auth")) {
	        $lb_params = array(
	            "token_key" => $token_key,
	        );
	        
	        if($$obj = self::loadBy($lb_params)) {
	            return $$obj->object->id;
	        }
	    }
	    
	    return false;
	}
	
	public static function getRolesList() {
	    return self::$roles;
	}
	
	public static function getRoleById($id = 0) {
	    return self::$roles[$id];
	}
	
	public function generateTokenKey($string = "") {
	    return md5($string);
	}

	public static function CanUserSeeModule($user_id, $module_name){
		if ('1'/* system*/ == $user_id || '2'/* Администратор */ == $user_id ) {
			return true;
		}
		if (empty(self::$mainPageModules[$module_name]['userAccess'])) {
			return true;
		}
		foreach(self::$mainPageModules[$module_name]['userAccess'] as $item){
			if ($user_id == $item) {
				return true;
			}
		}
		return false;
	}

	public static function accessmatrixStore($params = array()){
		// var_dump($params["accessmatrix"]);
		$items = $params["accessmatrix"];
		$result = array();
		foreach($items as $key => $item){
			$doc_type = explode('_', $key)[0];
			$role_id = explode('_', $key)[1];
			$result[$doc_type][] = $role_id;
		}
		
		foreach($result as $key => $item){
			$id = self::loadBy(array('doctype' => $key))->object->id;
			if (!is_null($id) && false != $id) {
				$params["accessmatrix"] = array(
					'id' => $id,
					'doctype' => $key,
					'roles' => array(
						'access' => json_encode($item)
					)
				);
			}
			else{
				$params["accessmatrix"] = array(
					'doctype' => $key,
					'roles' => array(
						'access' => json_encode($item)
					)
				);
			}
			// var_dump($params);
			self::store($params);
		}
		// exit();
	}

	public static function ajaxDocTypeRoleMatrixStore($params){
		// var_dump($params);
		$tmp = $params["doctyperolematrix"];
		$doc_type = $tmp["doctype_id"];
		$step_order = self::getLastStepOrder($doc_type) + 1;
		$step = $tmp['step'];
		$role = $tmp["role_id"];

		$params["doctyperolematrix"] = array(
			'doctype' => $doc_type,
			'step_order' => $step_order,
			'step' => $step,
			'role' => $role
		);

		self::setObject("doctyperolematrix");
		self::store($params);
		exit();
	}
	private static function getLastStepOrder($doc_type){
		$lastStep = 0;
		self::setObject("doctyperolematrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doctype", "=", $doc_type)
			->parse();
		$tmp = self::getList($where);
		foreach($tmp as $key => $item){
			if ($item->object->step_order > $lastStep) {
				$lastStep = $item->object->step_order;
			}
		}
		return $lastStep;
	}


	/**
	 * @method \RedCore\Users\Collection GetDocTypesByUser()
	 *
	 * @return array array with accesses for doctype for current user - key = doctype_id, value - (true/false)
	 * 
	 */
	public static function GetDocTypesByUser($doctypes = array()){
		
		self::setObject('user');
		$user_role = self::getAuthRole();

		if (in_array($user_role, ['1', '2'])) {
			foreach($doctypes as $key => $item) {
				$res[$item] =  true;
			}
			return $res;
		}

		self::setObject("doctyperolematrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("role", "=", $user_role)
			->add("and")
			->add("step", "=", "1")//вытаскиваем только черновики
			->parse();
		$accessList = self::getList($where);
		foreach($accessList as $item) {
			$accessResult[$item->object->doctype] = true;
		}
		
		foreach($doctypes as $key => $item) {
			$res[$item] = empty($accessResult[$item]) ? false : true;
		}
		// var_dump($res);
		return $res;
	}

	//Тут была завязка на матрицу доступов
	public static function GetDocTypesByUserOld($doctypes = array()){
		
		self::setObject('user');
		$user_role = self::getAuthRole();

		self::setObject("accessmatrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->parse();
		$accessList = self::getList($where);
		foreach($accessList as $item){
			$accessResult[$item->object->doctype] = json_decode($item->object->roles->access);
		}

		foreach($doctypes as $key => $item){
			$res[$item] = in_array($user_role, $accessResult[$item]) ? true : false;
		}
	
		return $res;
	}

	/**
	 * @method \RedCore\Users\Collection GetNextStep()
	 *
	 * @return array [step] => next step, [role] => next role of document route
	 * 
	 */
	public static function GetNextStep($doc_type = -1, $current_step = -1, $current_role = -1) {
		if (-1 == $doc_type || -1 == $current_step || -1 == $current_role) return; 

		self::setObject("doctyperolematrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doctype", "=", $doc_type)
			->parse();
		$matrix = self::getList($where);

		foreach($matrix as $key => $item) {
			$item = $item->object;
			$matrix_ready[$item->step][$item->role] = $item->step_order;
			$tmpItem = array(
				"step" => $item->step,
				"role" => $item->role,
			);
			$matrix_ordered[$item->step_order] = $tmpItem;
		}
		$current_step_order = $matrix_ready[$current_step][$current_role];
		$i = 1;

		while(true) {
			if ($matrix_ordered[$current_step_order + $i]['step'] != '1') {
				$result['step'] = $matrix_ordered[$current_step_order + $i]['step'];
				$result['role'] = $matrix_ordered[$current_step_order + $i]['role'];
				break;
			}
			else {
				$i++;
			}
		}
		return $result;
	}

	/**
	 * @method \RedCore\Users\Collection GetDocRoute()
	 *
	 * @return array key => step order, values => steps and roles of document route
	 * 
	 */
	public static function GetDocRoute($doc_type = -1) {
		if (-1 == $doc_type) return;

		self::setObject("doctyperolematrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doctype", "=", $doc_type)
			->parse();
		$matrix = self::getList($where);
		
		foreach ($matrix as $key => $item) {
			$item=$item->object;
			$tmpArray = array(
				'step' => $item->step,
				'role' => $item->role
			);
			$result[$item->step_order] = $tmpArray;
		}

		ksort($result);
		return $result;
	}
	// todo
	public static function CanUserMoveRoute($doc_type = -1, $user_role = -1, $step = -1){
		if (-1 == $doc_type || -1 == $user_role || -1 ==$step) return;

		if('2' == $user_role || '1' == $user_role) return true;

		Users::setObject("user");
		if ($user_role == Users::getAuthRole()) {
			return true;
		}
		// self::setObject("doctyperolematrix");
		// $where = Where::Cond()
		// 	->add("_deleted", "=", "0")
		// 	->add("and")
		// 	->add("doctype", "=", $doc_type)
		// 	->parse();
		// $matrix = self::getList($where);
		
		// foreach ($matrix as $key => $item) {
		// 	$item=$item->object;
		// 	$tmpArray = array(
		// 		'step' => $item->step,
		// 		'role' => $item->role
		// 	);
		// 	$result[$item->step_order] = $tmpArray;
		// }
		// // var_dump($result);

		// foreach ($result as $key => $value) {
		// 	if ($value['step'] == $step && $value['role'] == $user_role) {
		// 		return true;
		// 	}
		// }
		return false;
	}

	public static function CanUserReadDocs($doctypes = array()){
		self::setObject('user');
		$user_role = self::getAuthRole();

		if (in_array($user_role, ['1', '2'])) {
			foreach($doctypes as $key => $item) {
				$res[$item] =  true;
			}
			return $res;
		}

		self::setObject("accessmatrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->parse();
		$accessList = self::getList($where);
		foreach($accessList as $item){
			$accessResult[$item->object->doctype] = json_decode($item->object->roles->access);
		}

		foreach($doctypes as $key => $item){
			$res[$item] = in_array($user_role, $accessResult[$item]) ? true : false;
		}
	
		return $res;
	}



}

?>