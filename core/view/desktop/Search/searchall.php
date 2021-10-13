<?php
use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where as Where;
use RedCore\Config as Config;

Session::bind("indocitems-list", "");

$session_doctypes = (int)Session::get("general_searchall");

Indoc::setObject("oindoc");

$where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->parse();

$documentIndoc = Indoc::getList($where);

$tmp = array();

foreach($documentIndoc as $document) {
    if($document->object->params->doctypes == $session_doctypes){
        $tmp[]=$document;
    }
}

$documentIndoc = $tmp;

?>
