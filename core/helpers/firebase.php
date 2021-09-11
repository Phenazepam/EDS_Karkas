<?php 

	function log2text($text = "") {
		$file = 'test.txt';
		$devices = serialize($devices);
		// Открываем файл для получения существующего содержимого
		$current = file_get_contents($file);
		// Добавляем нового человека в файл
		$current = $text;
		// Пишем содержимое обратно в файл
		file_put_contents($file, $current);
	}

	function sendPush($devices = array(), $title="", $body = "") {
		$server_id = 'AIzaSyAD-lNahgqfKfd8Bnt624PEYV 9SgOwhcqw';
		
		$headers = array(
			'Content-Type: application/json',
			'Authorization: key=AIzaSyAD-lNahgqfKfd8Bnt624PEYV 9SgOwhcqw'
		);
		
		$data = array(
			'registration_ids' => $devices,
			'notification' => array(
					'body' => $body,
					'title' => $title
			),
		);
		
		$data = json_encode($data, true);
		
		
		if($curl = curl_init()){
			curl_setopt($curl, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$out = curl_exec($curl);
		
			if(curl_errno($curl))
			{
				$rs = 'Ошибка curl: ' . curl_error($curl);
			}
			else {
				$rs = $out;
			}
		
			curl_close($curl);
		}
		else {
			$rs = "no";
		}
		
		log2text($devices . $rs . $data);
	}
	
	function sendData($devices = array(), $appdata = array()) {
		$server_id = 'AIzaSyAD-lNahgqfKfd8Bnt624PEYV 9SgOwhcqw';
		
		$headers = array(
			'Content-Type: application/json',
			'Authorization: key=AIzaSyAD-lNahgqfKfd8Bnt624PEYV 9SgOwhcqw'
		);
		
		$data = array(
			'registration_ids' => $devices,
			'data' => $appdata
		);
		
		$data = json_encode($data, true);
		
		
		if($curl = curl_init()){
			curl_setopt($curl, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			//$out = curl_exec($curl);
		
			if(curl_errno($curl))
			{
				$rs = 'Ошибка curl: ' . curl_error($curl);
			}
			else {
				$rs = $out;
			}
		
			curl_close($curl);
		}
		else {
			$rs = "no";
		}
		
		log2text($devices . $rs . $data);
	}

?>

