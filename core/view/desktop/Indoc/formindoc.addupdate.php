<?php

use RedCore\Forms;
use RedCore\Request;
use RedCore\Where;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Session;
use RedCore\Users\Collection as Users;

$html_object = "oindoc";

Indoc::setObject($html_object);

$lb_params = array(
    "id" => Request::vars("oindoc_id")
);

$doc_type = Request::vars("type");
if (is_null($doc_type)) {
    $doc_type = $oindoc_item->object->params->doctypes;
}

$oindoc_item = Indoc::loadBy($lb_params);

$select_params["list"] = Indoc::getStatuslist();

$where = Where::Cond()
    ->add("_deleted", "=", "0")
    ->parse();

Indoc::setObject("odoctypes");

$DocTypes = Indoc::getList($where);

$DocTypesid = array();
foreach ($DocTypes as $id => $temp) {
    $DocTypesid[$id] = $temp->object->id;
}

$DocTypesAcceess = Users::GetDocTypesByUser($DocTypesid);

$DocTypesResult["list"][0] = "Не выбрано";
foreach ($DocTypesAcceess as $key => $item) {
    if ($item) {
        $DocTypesResult["list"][$key] = $DocTypes[$key]->object->title;
    }
}

Users::setObject("user");

$user_role = Users::getAuthRole();

$user_id = $oindoc_item->object->user_id;
if (is_null($user_id))$user_id = Users::getAuthId();


$step = $oindoc_item->object->step;

$step_role = $oindoc_item->object->step_role;

$status_id = $oindoc_item->object->params->status_id;
if (is_null($status_id)) $status_id = "1";

// if (is_null(Request::vars("oindoc_id"))) {
//     $step = "1";
//     $step_role = $user_role;
// }

//  disabling form by role
$disable_form = "disabled";

if( $user_role == "2" ) {
	$disable_form = "";
}
if( $user_role == "1" ) {
	$disable_form = "";
}
if( $user_role == "19" ) {
	$disable_form = "";
}


if (is_null($doc_type)) {
    $doc_type = $oindoc_item->object->params->doctypes;
}
Session::set("s_relateddoc_id", $oindoc_item->object->id);
$relateddocs = require('RelatedDocView/generateRelatedDocView.php');
Session::delete("s_relateddoc_id", $oindoc_item->object->id);

$auto_reg_number = require('RelatedDocView/autoRegNumber.php');
$reg_number = $oindoc_item->object->reg_number;
if (is_null($reg_number)) {

	$reg_number = $auto_reg_number;
}

Indoc::setObject('odocfile');
$lb_params = array(
  'doc_id' => $doc_id,
  'iscurrent' => '1'
);
$doc_file = Indoc::loadBy($lb_params);
if (!empty($doc_file->object->id)){
    $downloadBtn = '<div class="row form-group" style="margin-top: 15px;"><div class="col col-md-12"><label for="" class="form-control-label">Прикрепленный файл</label></div>
                        <div class="col col-md-12">
                            <div class="row form-control">
                                <div class="col col-md-4">
                                    <div style="font-size: 17px; font-weight:600" >'.$doc_file->object->name.' от '.date('d.m.Y', strtotime($doc_file->object->_updated)).'</div>
                                </div>
                                <div class="col col-md-8">
                                    <a class="btn btn-info btn-sm" href = "/docs-download?file_id='.$doc_file->object->id .'">Скачать документ</a>
                                </div>
                            </div>
                        </div>
                    </div>';
}

$form = Forms::Create()
    ->add("action", "action", "hidden", "action", $html_object . ".store.do", 6, false)
    ->add("redirect", "redirect", "hidden", "redirect", "indocitems-list", 6, false)

    ->add("id", "id", "hidden", $html_object . "[id]", $oindoc_item->object->id)
    ->add("status_id", "status_id", "hidden", $html_object . "[params][status_id]", $status_id)
    ->add("user_id", "user_id", "hidden", $html_object . "[user_id]", $user_id)
    ->add("step_role", "step_role", "hidden", $html_object . "[step_role]", $step_role)
    ->add("doctypes", "Тип документа", "select", $html_object . "[params][doctypes]", $doc_type, 6, false, $DocTypesResult)
    ->add("name_doc", "Имя документа", "text", $html_object . "[name_doc]", $oindoc_item->object->name_doc)
    ->add("reg_number", "№ Регистрации", "text", $html_object . "[reg_number]", $reg_number, "", "", "", $disable_form)
    ->add("reg_date", "Дата регистрации", "text", $html_object . "[reg_date]", $oindoc_item->object->reg_date, "", "", "", $disable_form)

    ->add("html", "", "html", "", '<src="' . CMS_TMP . SEP . $oindoc_item->object->params->file_title . '">')
    ->add("file", "Файл", "file", $html_object . "[file]")
    ->add("html", "", "html", "", $downloadBtn)
    ->add("html", "", "html", "", $relateddocs)
    ->parse();
?>


<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    ДОКУМЕНТЫ<small>форма редактирования</small>
                </h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <?= $form ?>
                            <!-- <div id="tags_1_tagsinput" class="tagsinput" style="width: auto; min-height: 100px; height: 100px;">
                                <span class="tag">
                                    <span><a href="#">social</a></span>
                                    <a href="#" title="Removing tag">x</a>
                                </span>
                                <span class="tag" style="background-color: #0069d9;" >
                                    <span><a href="#">Добавить</a></span>
                                </span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style lang="css">
    .dov{
        border-width: 1px;
    }
</style>