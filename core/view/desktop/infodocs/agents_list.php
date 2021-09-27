<?php

use \RedCore\Infodocs\Collection as Test;

Test::setObject("oinfodocsagents");
$items = Test::getList();

?>

<a class="btn btn-primary" href="/infodocs-form">Добавить</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>id</th>
			<th>Наименование</th>
			<th>ИНН</th>
			<th>Группа</th>
			<th>Материал</th>
			<th>Ответственный</th>
			<th>Примечание</th>
		
		</tr>
	</thead>
	<tbody>

<?
    foreach($items as $item):
?>

	<tr>
		<td><?= $item->object->id ?></td>
		<td><?= $item->object->name ?></td>
		<td><?= $item->object->inn ?></td>
		<td><?= $item->object->group_ka ?></td>
		<td><?= $item->object->material ?></td>
		<td><?= $item->object->main_worker ?></td>
		<td><?= $item->object->other ?></td>
		<td><a class="badge badge-primary" href="/infodocs-form?otest_id=<?=$item->object->id?>">Редактировать</a></td>
	</tr>
	
<?
endforeach;	

?>
</tbody>
</table>