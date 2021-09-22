<?php

/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Indoc;

class ObjectDocLog extends \RedCore\Base\ObjectBase {
    
    public static function Create() {
        return new ObjectDocTypes();
    }
    
    public function __construct() {
        
        $this->table = "doclog";
        
        $this->properties = array(
            
            "id"         => "Number",
            "doc_id" => "Number",
            "action"   => "String",
            "comment"   => "String",
            "user_id"   => "Number",
            "_updated" => "Timestamp",
            "_deleted" => "Number"
        );
        
    }
}