<?php

use RedCore\Excel\Collection as Excel;
use RedCore\Session as Session;

$items = Session::get('s_excel_items');
$header_array = Session::get('s_excel_headers');

// var_dump($items);
// exit();
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . 'file.xlsx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

Excel::setObject('oexcel');
Excel::export($items, $header_array);

exit();

