<?php

use RedCore\Request;
use RedCore\Where;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Users\Collection as Users;
use RedCore\Session as Session;
use RedCore\Infodocs\Collection as Infodocs;


$where = $where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->parse();


// get table oindoc
Indoc::setObject("oindoc");
$docs = Indoc::getList();

// get registration numbers from table
$a = array();
    foreach($docs as $item) {
		$c = $item->object->reg_number;
		array_push($a, $c);
	}

//searching max value and increment it
$max = max($a);
$new_number = $max +1;
$stringNewNum = (string) $new_number;


return $stringNewNum;
//return $new_number;
?>
