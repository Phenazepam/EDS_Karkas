<?php
use RedCore\Users\Collection as User;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;

$stepsList = Indoc::getRouteStatuses();
$rolesList = User::getRolesList();

User::setObject("doctyperolematrix");
$doctype_id = $_REQUEST["doctype_id"];
$role_id = $_REQUEST["role_id"];

$where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->add("and")
    ->add("doctype", "=", $doctype_id)
    ->parse();

$disabled = 'disabled';
$tmp = User::getList($where);
foreach($tmp as $i){
    if ('1' == $i->object->step) {
        $disabled = '';
        break;
    }
}
foreach($tmp as $i){
    $steps_ready[$i->object->step_order]["title"] =  $i->object->step_order.'. '.
        $rolesList[$i->object->role].' - '. $stepsList[$i->object->step];
        $steps_ready[$i->object->step_order]["role"] = $i->object->role;
}
ksort($steps_ready);

$title =Indoc::getDocTypesList()[$doctype_id] .' / '. User::getRolesList()[$role_id];
// var_dump($steps);
?>
<script src="/core/view/desktop/Users/js/popupForChoosingStep.js"></script>

<h3><?=$title?></h3>
<hr>
<h5>Шаги документа:</h5>
<div style="text-align: left;">
    <?php
        foreach($steps_ready as $key => $item):
        $txt = $item["title"];
    ?>
    <p>
        <?=$item["title"] ?>
        <?php if ($item['role'] == $role_id) : ?>

        <i class="fa fa-trash" style="cursor: pointer"
            onclick="popupForDeletingStep(<?= $doctype_id ?>, <?= $key ?>, <?= $key ?>)"></i>
        <?php endif; ?>
    </p>
    <?php
        endforeach;
    ?>
</div>
<hr>
<h5>Добавить новый шаг из списка</h5>
<form action="/doctyperolematrix-list?action=doctyperolematrix.store.do" 
    method="post" id="popup" name="doctyperolematrix"> 
    <div class="popup_body">
        <input type="hidden" name="doctyperolematrix[role_id]" value="<?=$role_id?>">
        <input type="hidden" name="doctyperolematrix[doctype_id]" value="<?=$doctype_id?>">
        <p><input name="doctyperolematrix[step]" type="radio" value="1" id="draft">
            <label class="popup_label" for="draft">Черновик</label>
        </p>
        <p><input name="doctyperolematrix[step]" type="radio" value="2" id="agreement" <?=$disabled?>>
            <label class="popup_label" for="agreement">Согласование</label>
        </p>
        <p><input name="doctyperolematrix[step]" type="radio" value="3" id="approval" <?=$disabled?>>
            <label class="popup_label" for="approval">Утверждение</label>
        </p>
        <p><input name="doctyperolematrix[step]" type="radio" value="4" id="adoption" <?=$disabled?>>
            <label class="popup_label" for="adoption">Принятие</label>
        </p>
    </div>
    <!-- <button type="submit">Сохранить</button> -->
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
