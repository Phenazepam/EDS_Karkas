<?php
use RedCore\Forms;
use RedCore\Request;
use RedCore\Where;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Users\Collection as Users;

$html_object = "oindoc";

Indoc::setObject($html_object);

$lb_params = array(
    "id" => Request::vars("oindoc_id")
);

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

$step = $oindoc_item->object->step;

$step_role = $oindoc_item->object->step_role;

if (is_null(Request::vars("oindoc_id"))) {
    $step = "1";
    $step_role = $user_role;
}
$form = Forms::Create()
    ->add("action", "action", "hidden", "action", $html_object . ".store.do", 6, false)
    ->add("redirect", "redirect", "hidden", "redirect", "indocitems-list", 6, false)
    
    ->add("id", "id", "hidden", $html_object . "[id]", $oindoc_item->object->id)
    ->add("step", "step", "hidden", $html_object . "[step]", $step)
    ->add("step_role", "step_role", "hidden", $html_object . "[step_role]", $step_role)
    ->add("doctypes", "Тип документа", "select", $html_object . "[params][doctypes]", $oindoc_item->object->params->doctypes, 6, false, $DocTypesResult)
    ->add("name_doc", "Имя документа", "text", $html_object . "[name_doc]", $oindoc_item->object->name_doc)
    ->add("reg_number", "№ Регистрации", "text", $html_object . "[reg_number]", $oindoc_item->object->reg_number)
    ->add("reg_date", "Дата регистрации", "text", $html_object . "[reg_date]", $oindoc_item->object->reg_date)
    
    ->add("html", "", "html", "", '<src="' . CMS_TMP . SEP . $oindoc_item->object->params->file_title . '">')
    ->add("file", "Файл", "file", $html_object . "[file]")
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
                			<?=$form?>
       					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>