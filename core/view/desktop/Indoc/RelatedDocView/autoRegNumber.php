<?php

use RedCore\Request;
use RedCore\Where;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Users\Collection as Users;
use RedCore\Session as Session;
use RedCore\Infodocs\Collection as Infodocs;


$where = $where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->add("and")
    ->add("doc_id", "=", $doc_id)
    ->parse();

if (0 != $doc_id) {
    Indoc::setObject("orelateddocs");
    $relateddocs = Indoc::getList($where);
}

Indoc::setObject("oindoc");
$docs = Indoc::getList();


$a = array();
    foreach($docs as $item) {
		array_push($a, <?= $item->object->reg_number ?>)
	}
$max = max($a);
$new_number = $max +1;
//$stringNewNum = (string) $new_number;



return $new_number;
?>
