<?php

use RedCore\Response as Response;
use RedCore\Request as Request;
use RedCore\Users\Collection as Users;
use RedCore\Where;


$response = Response::Create()
	->setAction("user-get-history")
	->isError("token_key", true, true);

if($response->noErrors()) {
	$lb_params = array(
		"token_key" => Request::vars("token_key")
	);
	
	Users::setObject("user");
	
	if($user = Users::loadBy($lb_params)) {
		$free = array();
		
		/*$where = Where::Cond()
			->add("user_id", "=", $user->object->id)
			->parse();
		
		Users::setObject("history");
		$history = Users::getList($where);
		$free = array();
		
		foreach($history as $historyitem) {
			$free[] = array(
				$historyitem->object->photo_url,
				$historyitem->object->photo_date,
				$historyitem->object->photo_coords
			);
		}*/
		
		$vk_id = explode("vk", $user->object->login);
		$vk_id = $vk_id[1];
		$is_vk = (int)$vk_id > 0;
		
		
		if($is_vk) {
			$user_id = $vk_id;
			
			$llburl = 'https://api.vk.com/method/wall.get?owner_id='.$user_id.'&filter=owner&count=100&service_token=d324bba0d324bba0d324bba08cd378c1dddd324d324bba08ace298c5ec74b4b79417acf';
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $llburl);

			$data = curl_exec($ch);
			curl_close($ch);
			
			$data = json_decode($data);
			
			if(isset($_REQUEST["test"])) {
				print_r($data);
			}

			foreach($data->response as $post) {
				//if(!empty($post->geo->coordinates)) echo $post->geo->coordinates;
				list($x, $y) = explode(" ", $post->geo->coordinates);
				
				if(((float)$x > 0) AND ((float)$y > 0)) {
					$coords = array("x" => $x, "y" => $y);
					
					if(!empty($post->attachment->photo->src)) {
						$free[] = array(
							$post->attachment->photo->src,
							$post->date,
							$coords,
						);
					}
				}
				
				foreach($post->attachments as $photo) {
					$x = $photo->photo->lat;
					$y = $photo->photo->long;
					
					if(((float)$x > 0) AND ((float)$y > 0)) {
						$coords = array("x" => $x, "y" => $y);
						
						if(!empty($photo->photo->src)) {
							$free[] = array(
								$photo->photo->src,
								$photo->photo->created,
								$coords,
							);
						}
					}
				}
			}
			
			
			
			/*$llburl = 'https://api.vk.com/method/photos.get?owner_id='.$user_id.'&album_id=profile&access_token='.$service_token;
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $llburl);

			$data = curl_exec($ch);
			curl_close($ch);
			
			$data = json_decode($data);

			foreach($data->response as $post) {
				
				$x = $post->lat;
				$y = $post->long;
				
				if(((float)$x > 0) AND ((float)$y > 0)) {
					$coords = array("x" => $x, "y" => $y);
					
					if(!empty($post->src)) {
						$free[] = array(
							$post->src,
							$post->created,
							$coords,
						);
					}
				}
			}*/
		}
		
	}
	else {
		$response->setError("user", "003");
	}
	
	$data = "";
	$data->history = $free;
	$response->setData($data);
}

echo $response->output("json");