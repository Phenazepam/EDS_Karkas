<?php
use RedCore\Users\Collection as Users;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;

$doc_id = $_REQUEST['oindoc_id'];

$isBack = $_REQUEST['isback'];

Indoc::setObject("oindoc");
$data = Indoc::loadBy(array('id' => $doc_id));
$doc_type = $data->object->params->doctypes;

Users::setObject('user');
// $user_id = Users::getAuthRole();
$users_list = Users::getList();

Indoc::setObject('odocroute');
$lb_params = array(
    'doc_id' => $doc_id,
    'iscurrent' => '1'
);

$current_step = Indoc::loadBy($lb_params);
$current_step_order = $current_step->object->step_order;

$doc_steps = Indoc::getRouteStatuses();

$user_roles = Users::getRolesList();

if (1 == $isBack) {
    $tmp = Users::GetPrevStep($doc_id, $current_step_order);
}
else {
    $tmp = Users::GetNextStep($doc_type, $current_step_order);
}
$next_step = $tmp['step'];
$next_role = $tmp['role'];
$step_order = $tmp['step_order'];
$user_id = $tmp['user_id'];
if (0 != $user_id) {
    $name = ' ('.$users_list[$user_id]->object->params->f . ' ' . $users_list[$user_id]->object->params->i.')';
}
$isFinalStep = Users::IsLastStep($doc_type, $current_step_order) ? 1 : 0;
?>
<?php
    if (1 == $isFinalStep) :
?>
<h3>Выполнить <?= $doc_steps[$current_step->object->step] ?> документа?</h3>
<?else:?>
<h3>Отправить документ на </h3>
<h5 style="text-align: center;">
    <b><?= $doc_steps[$next_step] ?></b> для <b><?= $user_roles[$next_role] ?></b>
    <br>
    <b><?= $name ?></b>
</h5>
<?endif;?>
<hr>
<form action="/indocitems-form-view?action=oindoc.ajaxMoveRoute.do" 
    method="post" id="popup" name="oindoc"> 
    <div class="popup_body">
        <input type="hidden" name="oindoc[id]" value="<?=$doc_id?>">
        <input type="hidden" name="oindoc[step_role]" value="<?=$next_role?>">
        <input type="hidden" name="oindoc[step]" value="<?=$next_step?>">
        <input type="hidden" name="oindoc[step_order]" value="<?=$step_order?>">
        <input type="hidden" name="oindoc[doc_type]" value="<?=$doc_type?>">
        <input type="hidden" name="oindoc[user_id]" value="<?=$user_id?>">
        <input type="hidden" name="oindoc[isback]" value="<?=$isBack?>">
        <input type="hidden" name="oindoc[isFinalStep]" value="<?=$isFinalStep?>">
        <div style="min-width: 200px; text-align: center;">
            Комментарий: <br>
            <textarea type="textarea" name="oindoc[comment]" id="comment" cols="50" rows="8" style="min-width: 350px;font-size:medium"></textarea>
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