<?php
use RedCore\Users\Collection as Users;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;

$rec_id = $_REQUEST['rec_id'];

Indoc::setObject("orecognition");
$data = Indoc::loadBy(array('id' => $rec_id));
$text = $data->object->rec_text;
?>
<form action="/indocitems-form-view?action=oindoc.ajaxMoveRoute.do" 
    method="post" id="popup" name="oindoc"> 
    <div class="popup_body" style="text-align: left;">
        <?=$text?>
    </div>
</form>