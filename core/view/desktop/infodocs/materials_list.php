<?php

use \RedCore\Infodocs\Collection as Materials;

Materials::setObject("oinfodocsmaterials");
$items = Materials::getList();

?>

<!--<a class="btn btn-primary" href="/infodocs-form">Добавить</a>-->

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>id</th>
			<th>Cчет учета</th>
			<th>Код</th>
			<th>Группа</th>
			<th>Материал</th>
			<th>Единица измерения</th>
		
		</tr>
	</thead>
	<tbody>

<?
    foreach($items as $item):
?>

	<tr>
		<td><?= $item->object->id ?></td>
		<td><?= $item->object->su ?></td>
		<td><?= $item->object->code ?></td>
		<td><?= $item->object->group ?></td>
		<td><?= $item->object->material ?></td>
		<td><?= $item->object->izm ?></td>
		<!--<td><a class="badge badge-primary" href="/infodocs-form?otest_id=<?=$item->object->id?>">Редактировать</a></td>-->
	</tr>
	
<?
endforeach;	

?>
</tbody>
</table>