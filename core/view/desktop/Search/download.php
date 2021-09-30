<?php

use RedCore\Search\Collection as Search;


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . 'file.xls');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

Search::setObject('osearch');
Search::export($header_array, $items);

exit();