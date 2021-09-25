<?php
use RedCore\Users\Collection as Users;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;

$doc_id = $_REQUEST['oindoc_id'];
$cstep = $_REQUEST['cstep'];
$crole = $_REQUEST['crole'];

Indoc::setObject("oindoc");
$data = Indoc::loadBy(array('id' => $doc_id));

$doc_type = $data->object->params->doctypes;

$doc_steps = Indoc::getRouteStatuses();

$user_roles = Users::getRolesList();

$tmp = Users::GetNextStep($doc_type, $cstep, $crole);
$next_step = $tmp['step'];
$next_role = $tmp['role'];

// var_dump(Users::GetNextStep($doc_type));
?>
<h3>Отправить документ на </h3>
<h5 style="text-align: center;">
    <?=$doc_steps[$next_step]?> для <?= $user_roles[$next_role]?>
</h5>
<hr>
<form action="/indocitems-form-view?action=oindoc.ajaxMoveRoute.do" 
    method="post" id="popup" name="oindoc"> 
    <div class="popup_body">
        <input type="hidden" name="oindoc[id]" value="<?=$doc_id?>">
        <input type="hidden" name="oindoc[step_role]" value="<?=$next_role?>">
        <input type="hidden" name="oindoc[step]" value="<?=$next_step?>">
        <div style="min-width: 200px; text-align: center;">
            Комментарий: <br>
            <textarea type="textarea" name="oindoc[comment]" id="comment" cols="50" rows="8" style="min-width: 350px;"></textarea>
        </div>
    </div>
</form>
<style lang="css">
    .popup_body{
        text-align: left;
        font-size: 25px;
    }
    .popup_lable{
        font-size: 40px;
        margin-left: 5px;
    }
</style>