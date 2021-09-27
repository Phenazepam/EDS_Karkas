<?php

use \RedCore\Infodocs\Collection as MainList;

MainList::setObject("oinfodocs");
$items = MainList::getList();

?>
	<div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>перечень справочников</small></h2>
        <div class="clearfix"></div>
     </div>
<!--<a class="btn btn-primary" href="/infodocs-form">Добавить</a>-->

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>id</th>
			<th>Наименование</th>
			<th>Ссылка</th>
		
		</tr>
	</thead>
	<tbody>

<?
    foreach($items as $item):
?>

	<tr>
		<td><?= $item->object->id ?></td>
		<td><?= $item->object->title ?></td>
		<td><a class="btn btn-primary" href=<?= $item->object->param_link ?>>Перейти</a></td>
		<!--<td><a class="badge badge-primary" href="/infodocs-form?otest_id=<?=$item->object->id?>">Редактировать</a></td>-->
	</tr>
	
<?
endforeach;	

?>
</tbody>
</table>