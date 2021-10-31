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
$where = Where::Cond()
->add("_deleted", "=", "0")
->parse();

$docs = Indoc::getList($where);

$chern = array();
$sogl = array();
$utv = array();
$prin = array();

$user_role = Users::getAuthRole();

// sort by statuses
    foreach($docs as $item) {
		//if ( $item->object->user_id == $user_role ){
			if ( $item->object->status == "1" ) {
				array_push($chern, $item->object->status);
			}elseif ( $item->object->status == "2" ) {
				array_push($sogl, $item->object->status);
			}elseif ( $item->object->status == "3" ) {
				array_push($utv, $item->object->status);
			}elseif ( $item->object->status == "4" ) {
				array_push($prin, $item->object->status);
			}
		//}
	}

//return result
$resChern = count($chern);
$resSogl = count($sogl);
$resUtv = count($utv);
$resPrin = count($prin);

$retResult = array();
$retResult[0] = $resChern;
$retResult[1] = $resSogl;
$retResult[2] = $resUtv;
$retResult[3] = $resPrin;


return $retResult;
?>