<?php

use \RedCore\Infodocs\Collection as Standarts;
use \RedCore\Where as Where;

Standarts::setObject("oinfodocsstandarts");
$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();
$items = Standarts::getList($where);

?>
<script src="/core/view/desktop/Excel/UploadFile.js"></script>
	<div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>перечень норм</small></h2>
        <div class="clearfix"></div>
     </div>
<a class="btn btn-primary" href="/infodocs-standartsform">Добавить</a>
<button class="btn btn-primary" onclick="ShowModalForUpload('standarts')">Загрузить данные из файла</button>
<!--<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">-->
<table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="th-sm">id</th>
			<th class="th-sm"> </th>
			<th class="th-sm">ед.изм</th>
			<th class="th-sm">Коэф. умнож.</th>
			<th class="th-sm">БП</th>
			<th class="th-sm">ФП</th>
			<th class="th-sm">Ростверк</th>
			<th class="th-sm">Стены</th>
			<th class="th-sm">Колонны</th>
			<th class="th-sm">Перекрытия</th>
			<th class="th-sm">Балки</th>
			<th class="th-sm">Ригельное перекрытие</th>
			<th class="th-sm">Мелкие конструкции</th>
			<th class="th-sm">Декор. элементы</th>
			<th class="th-sm">Прям. лест. марши</th>
			<th class="th-sm">Крив. лест. марши</th>
			<th>Действия</th>
		
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
		<td>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Действия
                </button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="/infodocs-standartsform?oinfodocsstandarts_id=<?=$item->object->id?>">Редактировать</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="/infodocs-standarts?action=oinfodocsstandarts.delete.do&oinfodocsstandarts[id]=<?= $item->object->id ?>">Удалить</a>
				</div>
            </div>
        </td>
		
		
		<!--<td><a class="badge badge-primary" href="/infodocs-form?otest_id=<?=$item->object->id?>">Редактировать</a></td>-->
	</tr>
	
<?
endforeach;	
?>
</tbody>
</table>