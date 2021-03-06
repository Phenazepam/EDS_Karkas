<?php

/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Users;

use \RedCore\Logger\Collection as Logger;
use \RedCore\Users\Collection as Users;
use \RedCore\Indoc\Collection as Indoc;
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

	public static function getUserNameById($user_id){
		self::setObject('user');
		$users_list = Users::getList();
		return $users_list[$user_id]->object->params->f . ' ' . $users_list[$user_id]->object->params->i;
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

		if (is_null($step) || is_null($role)) {
			$out = array(
				'errorCode' => '2',
				'errorText' => 'Нельзя добавить пустой шаг.'
			);
		}
		else
		if (!self::CheckStepExistence($doc_type, $step, $role)) {
			$params["doctyperolematrix"] = array(
				'doctype' => $doc_type,
				'step_order' => $step_order,
				'step' => $step,
				'role' => $role
			);

			$out = array(
				'errorCode' => '0',
				'errorText' => ''
			);
			self::setObject("doctyperolematrix");
			self::store($params);
		}
		else{
			$out = array(
				'errorCode' => '1',
				'errorText' => 'Данный шаг уже добавлен.'
			);
		}
		echo json_encode($out);
		exit();
	}
	public static function ajaxDocTypeRoleMatrixDelete($params){
		// var_dump($params);
		$tmp = $params["doctyperolematrix"];
		$doc_type = $tmp["doctype_id"];
		$stepOrder = $tmp['stepOrder'];

		self::setObject("doctyperolematrix");
		$lb_params = array(
			'doctype' => $doc_type,
			'step_order' => $stepOrder
		);
		$stepForDelete = self::loadBy($lb_params);
		$paramsForDelete["doctyperolematrix"] = array(
			'id' => $stepForDelete->object->id,
		);
	
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doctype", "=", $doc_type)
			->parse();
		$stepForUpd = self::getList($where);

		$flag = false;
		foreach($stepForUpd as $key => $item) {
			$item = $item->object;
			if ($flag) {
				$paramsForUpd["doctyperolematrix"] = array(
					'id' => $item->id,
					'step_order' => $item->step_order - 1 
				);
				self::store($paramsForUpd);
			}
			if ($item->step_order == $stepOrder) {
				$flag = true;
			}
		}

		parent::delete($paramsForDelete);

		$out = array(
			'errorCode' => '0',
			'errorText' => ''
		);
		echo json_encode($out);
		exit();
	}

	public static function CheckStepExistence($doc_type, $step, $role) {
		self::setObject("doctyperolematrix");
		$lb_params = array(
			'doctype' => $doc_type,
			'step' => $step,
			'role' => $role,
		);
		$data = self::loadBy($lb_params);
		if (!empty($data)) return true;
		else return false;
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
	public static function GetNextStep($doc_type = -1, $current_step_order = -1) {
		if (-1 == $doc_type || -1 == $current_step_order) return; 

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
		// $current_step_order = $matrix_ready[$current_step][$current_role];
		$i = 1;

		while(true) {
			if ($matrix_ordered[$current_step_order + $i]['step'] != '1') {
				$result['step'] = $matrix_ordered[$current_step_order + $i]['step'];
				$result['role'] = $matrix_ordered[$current_step_order + $i]['role'];
				$result['step_order'] = $current_step_order + $i;
				$result['user_id'] = 0;
				break;
			}
			else {
				$i++;
			}
		}
		return $result;
	}

	public static function GetPrevStep($doc_id = -1, $current_step_order = -1) {
		if (-1 == $doc_id || -1 == $current_step_order) return; 

		self::setObject("odocroute");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doc_id", "=", $doc_id)
			->parse();
		$route = self::getList($where);

		// var_dump($current_step_order);
		foreach($route as $key => $item) {
			$item = $item->object;
			$route_ready[$item->step_order] = $item;
		}

		$i = 1;
		while($i < 20){
			if (isset($route_ready[$current_step_order - $i])) {
				$result['step'] = $route_ready[$current_step_order - $i]->step;
				$result['role'] = $route_ready[$current_step_order - $i]->role_id;
				$result['step_order'] =$route_ready[$current_step_order - $i]->step_order;
				$result['user_id'] =$route_ready[$current_step_order - $i]->user_id;
				break;
			}
			$i++;
		}
		
		// var_dump(isset($route_ready[$current_step_order - 2]));
		return $result;
	}

	/**
	 * @method \RedCore\Users\Collection GetDocRoute()
	 *
	 * @return array key => step order, values => steps and roles of document route
	 * 
	 */
	public static function GetDocRoute($doc_type = -1, $doc_id = -1) {
		if (-1 == $doc_type) return;

		self::setObject("doctyperolematrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doctype", "=", $doc_type)
			->parse();
		$matrix = self::getList($where);

		Indoc::setObject("odocroute");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doc_id", "=", $doc_id)
			->parse();
		$routes = self::getList($where);

		foreach ($routes as $item) {
			$item = $item->object;
			$tmpArray = array(
				'step' => $item->step,
				'role' => $item->role_id,
				'user_id' => $item->user_id,
				'iscurrent' => $item->iscurrent
			);
			$routes_ready[$item->step_order] =  $tmpArray;
		}

		// var_dump($routes_ready);
		
		foreach ($matrix as $key => $item) {
			$item=$item->object;
			// var_dump($routes_ready[$item->step_order]);
			if (!empty($routes_ready[$item->step_order])) {
				$result[$item->step_order] = $routes_ready[$item->step_order];
			}
			else {
				$tmpArray = array(
					'step' => $item->step,
					'role' => $item->role,
					'user_id' => 0,
					'iscurrent' => 0
				);
				$result[$item->step_order] = $tmpArray;
			}
		}
		ksort($result);
		return $result;
	}

	public static function CanUserMoveRoute($doc_id = -1, $user_role = -1, $step = -1){
		if (-1 == $doc_id || -1 == $user_role || -1 ==$step) return;

		Indoc::setObject("oindoc");
		$document = Indoc::loadBy(array('id' => $doc_id));

		if(5 == $document->object->status || 6 == $document->object->status) return false;

		Users::setObject("user");
		$current_role = Users::getAuthRole();
		if('2' == $current_role || '1' == $current_role) return true;

		if ($user_role == $current_role) {
			return true;
		}
		return false;
	}
	public static function CanUserMoveRouteBack($doc_id = -1){
		if (-1 == $doc_id) return;

		Indoc::setObject("oindoc");
		$document = Indoc::loadBy(array('id' => $doc_id));
		$doc_type = $document->object->params->doctypes;

		if(5 == $document->object->status || 6 == $document->object->status) return false;

		Users::setObject("user");
		$current_role = Users::getAuthRole();
		if (1 == $current_role || 2 == $current_role) return true;
		
		self::setObject("doctyperolematrix");
		$where = Where::Cond()
		->add("_deleted", "=", "0")
		->add("and")
		->add("doctype", "=", $doc_type)
		->parse();
		$matrix = self::getList($where);
		
		foreach($matrix as $key => $item) {
			$item = $item->object;
			$matrix_ordered[$item->step_order] = $item->role;
		}

		if (in_array($current_role, $matrix_ordered)) {
			return true;
		}
		return false;
	}

	public static function IsLastStep($doc_type = -1, $current_step_order){
		if (-1 == $doc_type || -1 == $current_step_order) return;

		self::setObject("doctyperolematrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doctype", "=", $doc_type)
			->parse();
		$matrix = self::getList($where);
		$max_order = -1;
		foreach ($matrix as $key => $item) {
			$item=$item->object;
			$max_order = $item->step_order > $max_order ? $item->step_order : $max_order;
		}
		if ($current_step_order == $max_order) {
			return true;
		}
		return false;
	}
	public static function GetMoveRouteButtonName($doc_type = -1, $current_step_order){
		if (-1 == $doc_type || -1 == $current_step_order) return;

		self::setObject("doctyperolematrix");
		$where = Where::Cond()
			->add("_deleted", "=", "0")
			->add("and")
			->add("doctype", "=", $doc_type)
			->parse();
		$matrix = self::getList($where);
		$max_order = -1;
		foreach ($matrix as $key => $item) {
			$item=$item->object;
			$matrix_ready[$item->step_order] = $item;
			$max_order = $item->step_order > $max_order ? $item->step_order : $max_order;
		}
		$last_step = $matrix_ready[$max_order]->step;
		if ($current_step_order < $max_order) {
			return "Отправить документ далее";
		}
		else {
			if ($last_step == '3') return 'Утвердить';
			if ($last_step == '4') return 'Принять';
		}
		return false;
	}
	public static function IsFirstStep($doc_type = -1, $current_step_order){
		if (-1 == $doc_type || -1 == $current_step_order) return;

		if (1 == $current_step_order ) return true;

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

	public static function CanUserSeeDocLog($user_role = -1){

		$permission = array(
			"1" ,
			"2" ,
			"5" ,
			"9" ,
			"11",
			"13",
			"18",
			"19",
		);
		if (in_array($user_role, $permission))
			return true;
		
		return false;
	}




}

?>