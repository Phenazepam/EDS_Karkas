<?php

/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore;

class Response {

	private static $errors = array(
		"001" => array(
			"code"       => "001",
			"error_text" => "Required variable is missing: &var_name"
		),	
		"002" => array(
			"code"       => "002",
			"error_text" => "Required variable is empty: &var_name"
		),	
		"003" => array(
			"code"       => "003",
			"error_text" => "Requested object not found: &var_name"
		),
		"004" => array(
			"code"       => "004",
			"error_text" => "Object already exist: &var_name"
		)
	);
	
	private $response = array(
		"action"     => "",
		"error"      => false,
		"data"       => "",
		"error_data" => array(),
	);

	public static function Create() {
		$error = new Response();
		return $error;
	}
	
	public function isError($var_name, $is_isset = false, $is_empty = false) {
		if($is_isset AND (!isset($_REQUEST[$var_name]))) {
			$this->response["error_data"][] = $this->getError('001', $var_name);
		}
		elseif($is_empty AND (empty($_REQUEST[$var_name]))) {
			$this->response["error_data"][] = $this->getError('002', $var_name);
		}
		
		$this->response["error"] = count($this->response["error_data"]) > 0;
		return $this;
	}
	
	public function setError($var_name = "", $error_code = "") {
		$this->response["error_data"][] = $this->getError($error_code, $var_name);
		
		$this->response["error"] = count($this->response["error_data"]) > 0;
		return $this;
	}
	
	private function getError($error_code = '', $var_name = '') {
		$tmp = self::$errors[$error_code];
		$tmp["error_text"] = str_replace("&var_name", $var_name, $tmp["error_text"]);
		return $tmp;
	}
	
	public function setData($params = array()) {
		$this->response["data"] = $params;
		return $this;
	}
	
	public function setAction($action = '') {
		$this->response["action"] = $action;
		return $this;
	}
	
	public function noErrors() {
		return count($this->response["error_data"]) == 0;
	}
	
	public function output($type = "") {
		switch ($type) {
			case "json":
				return json_encode($this->response);
				break;
				
			default:
				return $this;
		}
	}
	
	
	/*
	
	public function toArray() {
		return $this->error_object;
	}*/
	
}

?>
