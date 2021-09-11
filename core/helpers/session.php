<?php

/**
 * Конфигурация домена.
 *
 * @package IPR
 * @copyright 2010
 * @author Darkas
 */
namespace RedCore;

class Session {
	
	public static $get_prefix = array();
	
	public static function Init(){
		$session = new Session;
		return $session;
	}
	
	public function __construct(){
		session_start();		
		
		/*
		 *@TODO Необходимо обнулять массив $_REQUEST после обрваботки необходимых значений, 
		 *чтобы искусственно вызывать ошибку при прямом доступе к данным $_REQUEST из модулей и представлений
		 */
	
	}
	
	public static function bind($request_var = "", $session_var = "", $default = 0) {
	    if(isset($_REQUEST[$request_var])) {
	        $_SESSION[$session_var] = $_REQUEST[$request_var];
	    }
	    elseif((!isset($_SESSION[$session_var])) AND (0 != (int)$default)) {
	        $_SESSION[$session_var] = $default;
	    }
	}
	
	public static function get($session_var = "") {
	    if(isset($_SESSION[$session_var])) {
	        return $_SESSION[$session_var];
	    }
	    else {
	        return FALSE;
	    }
	}
	
	public static function set($session_var = "", $session_value = "") {
	    if((!empty($session_var))AND(!empty($session_value))) {
	        $_SESSION[$session_var] = $session_value;
	        return true;
	    }
	    else {
	        return FALSE;
	    }
	}
	
	public static function delete($session_var = "") {
	    if(isset($_SESSION[$session_var])) {
	        unset($_SESSION[$session_var]);
	    }
	    else {
	        return FALSE;
	    }
	    
	}
}

Session::Init(); 


function arr_clear($a){
    if ($a !== array()){
    $b = array();
        foreach ($a as $key => $value){
            if (is_array($value)){
                if (clear($value) !== false){
                    $b[$key] = clear($value);
                }
            } elseif ($value !== ''){
                $b[$key] = $value;
            }
        }
        if ($b !== array()){
            return $b;
        } else {
            return false;
        }
    } else{
        return false;
    }
}


function mb_str_replace($needle, $replacement, $haystack) {
    $needle_len = mb_strlen($needle);
    $replacement_len = mb_strlen($replacement);
    $pos = mb_strpos($haystack, $needle);
    while ($pos !== false) {
      $haystack = 
         mb_substr($haystack, 0, $pos) . $replacement . 
         mb_substr($haystack, $pos + $needle_len);
      $pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
    }
    return $haystack;
  }