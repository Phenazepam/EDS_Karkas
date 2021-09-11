<?php

/**
 * Конфигурация домена.
 *
 * @package IPR
 * @copyright 2010
 * @author Darkas
 */

function sendRequest($action = "", $server = "", $data = array()) {
	$ch = curl_init($server . SEP . $action);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	return $result;
}

function array_keys_remove($arr = array()) {
	$free = array();
	
	foreach($arr as $ar) {
		$free[] = $ar;
	}
	
	return $free;
}

function withDefault($val = "") {
	if(empty($val)) {
		echo "------";
	}
	else {
		echo $val;
	}
}

/*
 * Получение IP пользователя
 */
function get_ip()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

/*
 * Проверка строки на JSON
 */

function is_json($string) {
    json_decode($string);
	return ((is_string($string))AND(json_last_error() == JSON_ERROR_NONE)AND(('{' == substr($string, 0, 1))OR('[' == substr($string, 0, 1))));
}

/*
 * Загрузка медиа
 */

function uploadPhoto($html_object = '', $field = '') {
	if(isset($_FILES[$html_object]['tmp_name'][$field])) {
		
		$tmp  = $_FILES[$html_object]['tmp_name'][$field];
		$name = $_FILES[$html_object]['name'][$field];
		$ext  = end(explode(".", $name));
		$title = md5(uniqid()) . "." . $ext;
		$filepath = IMAGES_PATH . $title;
			
		if(move_uploaded_file($tmp, $filepath)) {
			return $title;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

/*
 * Сравнение текста на схожесть
 */
function isMatch($text1 = "", $text2 = "") {
	//переводим текст в нижний регистр.
	$text1=strtolower($text1);
	$text2=strtolower($text2);
	//
	
	/*избавляемся от точек и прочих лишних символов
	 оставляем только слова
	 */
	$DelSymbols=array('~','!','@','#','$','%','^','&amp;amp;amp;','*',
			'(',')','-','_','+','=','|','?',',',
			'.','/',
			';',':','"','№');
	//теперь я удалю все и оставлю только слова
	//str_replace $DelSymbols можно дополнить
	// своими символами если недостаточно
	$text1=str_replace($DelSymbols,"",$text1);
	$text2=str_replace($DelSymbols,"",$text2);
	//echo $text1;
	//превращаем текст в массив из слов.
	$words1 = explode(" ", $text1);
	$words2 = explode(" ", $text2);
	
	//удаляем дубликаты
	$bufwords1=$words1;
	$bufwords2=$words2;
	$OneWords1=array_unique($bufwords1);
	$OneWords2=array_unique($bufwords2);
	
	//перезаписываем
	foreach ($OneWords1 as $element){
		$NewOneWords1[]=$element;
	}
	$OneWords1=$NewOneWords1;
	
	foreach ($OneWords2 as $element){
		$NewOneWords2[]=$element;
	}
	$OneWords2=$NewOneWords2;
	
	foreach($OneWords1 as $Word){
		$rep=CountReply($Word,$words1);
		$ReplyWord1[$Word]=$rep;
	}
	foreach($OneWords2 as $Word){
		$rep=CountReply($Word,$words2);
		$ReplyWord2[$Word]=$rep;
	}
	$C1=count($OneWords1);
	$sum=0;
	$K=0;//количество совпадений.
	for($i=0;$i<$C1;$i++){
		$res=$ReplyWord2[$OneWords1[$i]];
		if($res){
			$res2=$ReplyWord1[$OneWords1[$i]];
			$Diff=abs($res-$res2);
			$K++;
		}else{
			$Diff=0;
		}
		$sum=$sum+$Diff;
	}
	$NoWords1=$C1-$K;
	$NoWords2=count($OneWords2)-$K;
	$sum=$NoWords1+$NoWords2+$sum;
	$resultat=round(100-($sum*100/count($words1)));
	if($resultat<0){
		$resultat=0;
	}
	return $resultat;
}

//print_r($OneWords1);
//подсчитывает количество повторов для каждого слова
function CountReply($word,$text){
	$count=count($text);
	$res=0;
	for($i=0;$i<$count;$i++){
		if($word==$text[$i]){
			$res++;
		}
	}
	return $res;
}


/*
 * Перенос строки BR в /n
 */
function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}

/*
 * Русские месяцы именительный падеж
 */
function getRusMonth($m = 0) {
	$months = array(
		1 => 'январь',
		2 => 'февраль',
		3 => 'март',
		4 => 'апрель',
		5 => 'май',
		6 => 'июнь',
		7 => 'июль',
		8 => 'август',
		9 => 'сентябрь',
		10 => 'октябрь',
		11 => 'ноябрь',
		12 => 'декабрь',
	);
	return $months[$m];
}

/*
 * Русские месяцы родительный падеж
 */
function getRusMontha($m = 0) {
	$months = array(
		1 => 'января',
		2 => 'февраля',
		3 => 'марта',
		4 => 'апреля',
		5 => 'мая',
		6 => 'июня',
		7 => 'июля',
		8 => 'августа',
		9 => 'сентября',
		10 => 'октября',
		11 => 'ноября',
		12 => 'декабря',
	);
	return $months[$m];
}

function numberFormat($digit, $width) {
    while(strlen($digit) < $width)
      $digit = '0' . $digit;
      return $digit;
}


/*
 * Парсер CSV
 */
function getCSVList($params = array()) {
	$rs = array();
	$handle = fopen(CMS_DIR . $params["file"], "r");

	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		$num = count($data);
		$_tmp = array();
		
		for ($c=0; $c < $num; $c++) {
			$_tmp[] = $data[$c];
		}
		
		$rs[] = $_tmp;
	}
	
	fclose($handle);
	
	return $rs;
}

function utf8_replace( $ptr , $replace , $str , $cr = false ) {
    return preg_replace( '/'.preg_quote( $ptr , '/' ).'/su' . ($cr?'i':''), $replace , $str );
}

function getFTPFile($params = array()) {
	$conn_id      = ftp_connect($params["ip"]);
	$login_result = ftp_login($conn_id, $params["login"], $params["pass"]);
	
	ftp_chdir($conn_id, $params["path"]);
	
	if (ftp_get($conn_id, $params["localfile"], $params["serverfile"], FTP_BINARY)) {
		return true;
	} 
	else {
		return false;
	}

	ftp_close($conn_id); 
}

/**
 * Возвращает сумму прописью
 * @author runcore
 * @uses morph(...)
 */
function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',	 1),
        array('рубль'   ,'рубля'   ,'рублей'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}

if(!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $enc = 'utf-8') { 
    		return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc); 
    }
}

