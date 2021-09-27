<?php

use \RedCore\Infodocs\Collection as Standarts;

Standarts::setObject("oinfodocsstandarts");
$items = Standarts::getList();

?>

	<div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>перечень норм</small></h2>
        <div class="clearfix"></div>
     </div>
<!--<a class="btn btn-primary" href="/infodocs-form">Добавить</a>-->

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>id</th>
			<th> </th>
			<th>ед.изм</th>
			<th>Коэф. умнож.</th>
			<th>БП</th>
			<th>ФП</th>
			<th>Ростверк</th>
			<th>Стены</th>
			<th>Колонны</th>
			<th>Перекрытия</th>
			<th>Балки</th>
			<th>Ригельное перекрытие</th>
			<th>Мелкие конструкции</th>
			<th>Декор. элементы</th>
			<th>Прям. лест. марши</th>
			<th>Крив. лест. марши</th>
		
		</tr>
	</thead>
	<tbody>

<?
    foreach($items as $item):
?>

	<tr>
		<td><?= $item->object->id ?></td>
		<td><?= $item->object->name ?></td>
		<td><?= $item->object->izm ?></td>
		<td><?= $item->object->ku ?></td>
		<td><?= $item->object->bp ?></td>
		<td><?= $item->object->fp ?></td>
		<td><?= $item->object->rostverk ?></td>
		<td><?= $item->object->walls ?></td>
		<td><?= $item->object->kolon ?></td>
		<td><?= $item->object->perekryt ?></td>
		<td><?= $item->object->balki ?></td>
		<td><?= $item->object->rigel ?></td>
		<td><?= $item->object->smallconstr ?></td>
		<td><?= $item->object->decor ?></td>
		<td><?= $item->object->pryamlest ?></td>
		<td><?= $item->object->krivlest ?></td>
		<!--<td><a class="badge badge-primary" href="/infodocs-form?otest_id=<?=$item->object->id?>">Редактировать</a></td>-->
	</tr>
	
<?
endforeach;	

?>
</tbody>
</table>