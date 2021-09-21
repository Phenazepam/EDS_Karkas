<?php
use RedCore\Users\Collection as User;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;

User::setObject("doctyperolematrix");
$doctype_id = $_REQUEST["doctype_id"];
$role_id = $_REQUEST["role_id"];

$where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->add("and")
    ->add("doctype", "=", $doctype_id)
    ->parse();

$tmp = User::loadBy(array('doctype' => $doctype_id));
$steps_t = (array)json_decode($tmp->object->steps->steps);
foreach($steps_t as $key => $value){
    $steps[str_replace('"','',$key)] = $value;
}
if (!array_key_exists('1', $steps) || is_null($steps)) {
    $disabled = 'disabled';
}
// var_dump(($steps));
// var_dump(array_key_exists('1', $steps));

$title =Indoc::getDocTypesList()[$doctype_id] .' / '. User::getRolesList()[$role_id];
// var_dump($steps);
?>
<h3><?=$title?></h3>
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
