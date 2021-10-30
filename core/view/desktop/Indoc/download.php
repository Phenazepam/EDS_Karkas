<?php
use RedCore\Request;
use RedCore\Indoc\Collection as Indoc;

Indoc::setObject("odocfile");

$file_id = Request::vars('file_id');

$lb_params = array(
    "id" => $file_id
);

$item = Indoc::loadBy($lb_params);

$filename = $item->object->name;//.' от '. $item->object->_updated;
$directory = $item->object->directory;

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($filename));
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($directory));

readfile($directory);
exit();
?>