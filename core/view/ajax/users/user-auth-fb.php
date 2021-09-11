<?php

use RedCore\Response as Response;
use RedCore\Request as Request;
use RedCore\Users\Collection as Users;


$response = Response::Create()
	->setAction("user-auth-fb")
	->isError("user_id", true, true);

if($response->noErrors()) {
	$token_key = md5(Request::vars("user_id") . Request::vars("user_id"));
	
	$lb_params = array(
		"login" => 'fb' . Request::vars("user_id")
	);
	
	Users::setObject("user");
	
	if($user = Users::loadBy($lb_params)) {
		$user->token_key = $token_key;
		$user->store();
	}
	else {
		$params["user"] = array(
				"login"      => 'fb' . Request::vars("user_id"),
				"password"   => 'fb' . Request::vars("user_id"),
				"params"     => array(),
				"role"       => 1,
				"token_key"  => $token_key,
				"device_key" => "",
		);

		Users::store($params);
	}
	
	$data->token_key = $token_key;
	$response->setData($data);
}

echo $response->output("json");