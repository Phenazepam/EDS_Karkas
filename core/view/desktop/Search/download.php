<?php

use RedCore\Search\Collection as Search;
use RedCore\Session as Session;

$items = Session::get('s_items');
$header_array = Session::get('s_headers_array');

// var_dump($items);
// exit();
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . 'file.xlsx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

Search::setObject('osearch');
Search::export($items, $header_array);

exit();

