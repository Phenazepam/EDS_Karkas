<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;
use RedCore\Users\Collection as Users;

Indoc::setObject("odoctypes");
$where = Where::Cond()
        ->add("_deleted", "=", "0")
        ->parse();

$DocTypes_list = Indoc::getList($where);   
$DocTypesid = array();
foreach ($DocTypes_list as $id => $temp) {
    $DocTypesid[$id] = $temp->object->id;
}

Indoc::setObject("oindoc");

$where = Where::Cond()
        ->add("_deleted", "=", "0")
        ->parse();

$items = Indoc::getList($where);

$edit_doc = Indoc::CanUserEditDocs();

$doc_steps = Indoc::getRouteStatuses();

Indoc::setObject("odoclog");

$log = Where::Cond()
->add("doc_id", "=", $items->object->id)
->parse();

$doclog = Indoc::getList($log);

Users::setObject("user");

$user = Users::getRolesList();

$read_doc = Users::CanUserReadDocs($DocTypesid);

?>

<a class="btn btn-primary" href="/indocitems-form-addupdate">ДОБАВИТЬ</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>Тип документа</th>
			<th>Имя документа</th>
			<th>№ Регистрации</th>
			<th>Дата регистрации</th>
			<th>Назначенно на</th>
			<th>Шаг</th>
			<th>Файл</th>
			<th>Действие</th>
		</tr>
	</thead>
	<tbody>

<?
    foreach($items as $item):
        if ($read_doc[$item->object->params->doctypes]):

?>

	<tr>
		<td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
		<td><?= $item->object->name_doc ?></td>
		<td><?= $item->object->reg_number ?></td>
		<td><?= $item->object->reg_date ?></td>
		<td><?= $user[$item->object->step_role] ?></td>
		<td><?= $doc_steps[$item->object->step] ?></td>
		<td><img src="<?= IMAGES . SEP . $item->object->params->file_title ?>"></td>
		<td>
        	<div class="btn-group btn-group-sm">
            	<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Действия
            	</button>
        	<div class="dropdown-menu">
            	<a class="dropdown-item" href="/indocitems-form-view?oindoc_id=<?=$item->object->id?>">Просмотреть</a>
            <? if ($edit_doc[$item->object->id]):?>
            <div class="dropdown-divider"></div>
            	<a class="dropdown-item" href="/indocitems-form-addupdate?oindoc_id=<?=$item->object->id?>">Редактировать</a>
            <? endif;?>
            <div class="dropdown-divider"></div>
            	<a class="dropdown-item" href="/indocitems-form-delete?oindoc_id=<?=$item->object->id?>">Удалить</a>
            </div>
            	</div>
        			</td>
	</tr>
	
	
<?
    endif;
endforeach;	
?>
</tbody>
</table>