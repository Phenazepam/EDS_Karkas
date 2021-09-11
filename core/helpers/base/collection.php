<?php

/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Base;

use \RedCore\Controller as Controller;
use \RedCore\Core as Core;
use \RedCore\Where as Where;

require_once('object.php');

class Collection {
    
    public static $object = "";
    
    public static $sql    = "";
    
    public static $class  = "";
    
    public static function setObject($obj = "base") {
        if("base" == $obj) {
            self::$object = "base";
            self::$sql    = self::$sqlList;
            self::$class  = "RedCore\Base\ObjectBase";
        }
    }
    
    public static function loadBy($params = array()) {
        if(!is_array($params)) {
            $params = array($params);
        }
        
        $where = Where::Cond()
            ->add("1", "=", "1")
            ->add("and")
            ->add("_deleted", "=", "0");
        
        foreach($params as $field => $value) {
            if(!empty($field)) {
                $where = $where
                ->add("and")
                ->add($field, "=", $value);
            }
        }
        
        $where = $where->parse();
        
        $items = self::getList($where);
        
        if(count($items) > 0) {
            return $items = array_shift($items);
        }
        else {
            return false;
        }
    }
    
    public static function getList($where = "") {
        $data = Core::$db->executeAssoc(self::$sql . $where);
        $items = array();
        
        while ($row = $data->FetchRow()) {
            $class = self::$class;
            $oTmp  = $class::Create()
                ->setParams($row);
            
            $items[$row["id"]] = $oTmp;
        }
        
        return $items;
    }
    
    public static function store($params = array()) {
        $lb_params = array(
            "id" => $params[self::$object]["id"]
        );
        
        if($_tmp = self::loadBy($lb_params)) {
            $_tmp
            ->setParams($params[self::$object])
            ->store();
        }
        else {
            $class = self::$class;
            $_tmp = $class::Create()
                ->setParams($params[self::$object])
                ->store();
        }
        
        
        return $_tmp;
    }
    
    public static function delete($params = array()) {
        $lb_params = array(
            "id" => $params[self::$object]["id"]
        );

        if($_tmp = self::loadBy($lb_params)) {
            $_tmp->delete();
            return true;
        }
        else {
            return false;
        }
    }
}

?>
