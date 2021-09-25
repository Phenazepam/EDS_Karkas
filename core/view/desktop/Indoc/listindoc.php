<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;
use RedCore\Search\Collection as Search;

Indoc::setObject("odoctypes");
$where = Where::Cond()
        ->add("_deleted", "=", "0")
        ->parse();

$DocTypes_list = Indoc::getList($where);       
    
Indoc::setObject("oindoc");

$where = Where::Cond()
        ->add("_deleted", "=", "0")
        ->parse();

$items = Indoc::getList($where);

$status_list = Indoc::getStatuslist();

$header_array = array('Тип документа','Имя документа','№ Регистрации','Дата регистрации','Резолюция','Статус');

Search::export($header_array, $items);

?>

<a class="btn btn-primary" href="/indocitems-form-addupdate">ДОБАВИТЬ</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>Тип документа</th>
			<th>Имя документа</th>
			<th>№ Регистрации</th>
			<th>Дата регистрации</th>
			<th>Резолюции</th>
			<th>Статус</th>
			<th>Файл</th>
			<th>Действие</th>
		</tr>
	</thead>
	<tbody>

<?
    foreach($items as $item):


?>

	<tr>
		<td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
		<td><?= $item->object->name_doc ?></td>
		<td><?= $item->object->reg_number ?></td>
		<td><?= $item->object->reg_date ?></td>
		<td><?= $item->object->resolution ?></td>
		<td><?= $status_list[$item->object->params->status_id] ?></td>
		<td><img src="<?= IMAGES . SEP . $item->object->params->file_title ?>"></td>
		<td>
        	<div class="btn-group btn-group-sm">
            	<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Действия
            	</button>
        	<div class="dropdown-menu">
            	<a class="dropdown-item" href="/indocitems-form-addupdate?oindoc_id=<?=$item->object->id?>">Редактировать</a>
            <div class="dropdown-divider"></div>
            	<a class="dropdown-item" href="/indocitems-form-delete?oindoc_id=<?=$item->object->id?>">Удалить</a>
            </div>
            	</div>
        			</td>
	</tr>
	
<?
endforeach;	
?>
</tbody>
</table>