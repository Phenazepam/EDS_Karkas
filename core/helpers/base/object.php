<?php

/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Base;

use \RedCore\Validator as Validator;
use \RedCore\Core as Core;
use \RedCore\Config as Config;

class ObjectBase {
    
    public static function Create() {
        return new ObjectBase();
    }
    
    public function __construct() {
        $this->table = "base";
        
        $this->properties = array(
            "id"     => "Number",
            "title"  => "DbString",
            "params" => array(
                "login"    => "DbString",
                "password" => "DbString",
                "role"     => "Number",
            ),
            "_updated" => "DbString",
            "_deleted" => "Number",
        );
    }
    
    public function setParams($values = array()) {
        foreach($this->properties as $param => $type) {
            if(key_exists($param, $values)) {
                $value = $values[$param];
                
                if(is_array($type)) {
                    if(is_json($value)) {
                        $value = json_decode($value);
                    }
                    
                    if(is_array($value)) {
                        $value = (object)$value;
                    }
                    
                    foreach($type as $subparam => $subtype) {
                        $this->object->$param->$subparam = $value->$subparam;
                    }
                }
                else {
                    if(is_json($value)) {
                        $value = json_decode($value);
                    }
                    
                    $this->object->$param = $value;
                }
            }
        }
        
        return $this;
    }
    
    public function store() {
        $tmp_db_object = array();
        
        foreach($this->properties as $param => $type) {
            $value = $this->object->$param;           
            if(is_array($type)) {
                if(is_json($value)) {
                    $value = json_decode($value);                    
                }
                
                foreach($type as $subparam => $subtype) {
                    //$this->object->$param->$subparam = Validator::$subtype($value->$subparam);
                    $tmp_db_object[$param][$subparam] =  Validator::$subtype($value->$subparam);
                }
            }
            else {
                //$this->object->$param = Validator::$type($value);
                $tmp_db_object[$param] = Validator::$type($value);
            }
        }
        
        //$object = (array)$this->object;
        $object = $tmp_db_object;
        
        foreach($object as &$property) {
            if((is_object($property))OR(is_array($property))) {
                //$property = Validator::DbString(json_encode($property));
                $property = Validator::DbString(json_encode($property));
            }
            else {
                $property = Validator::DbString($property);
            }
        }
        
        Core::$db->replace(Config::$dbTablePrefix . $this->table, $object, "id");
        
        if(0 >= (int)$this->object->id) $this->object->id = Core::$db->insertId(Config::$dbTablePrefix . $this->table, "id");
        
        return $this;
    }
    
    public function clean() {
        if($this->isDelete()) {
            Core::$db->execute("DELETE FROM " . Config::$dbTablePrefix . $this->table . " WHERE id=" . $this->object->id);
            return true;
        }
        else {
            return false;
        }
    }
    
    public function delete() {
        $this->setDeleteStatus(1);
        return $this;
    }
    
    public function setDeleteStatus($status = 0) {
        $this->object->_deleted = $status;
        $this->store();
        return $this;
    }
    
    public function isDelete() {
        return (1 == $this->object->_deleted);
    }
    
}

?>
