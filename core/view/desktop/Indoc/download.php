<?php
use RedCore\Request;
use RedCore\Indoc\Collection as Indoc;

Indoc::setObject("oindoc");

$lb_params = array(
    "id" => Request::vars("oindoc_id")
);

$item = Indoc::loadBy($lb_params);

$file = CMS_TMP . SEP . $item->object->params->file_title;

header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename=' . basename($file));
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));

readfile($file);
exit();
?>