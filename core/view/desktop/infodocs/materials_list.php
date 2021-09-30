<?php

use \RedCore\Infodocs\Collection as Materials;

Materials::setObject("oinfodocsmaterials");
$items = Materials::getList();

?>
	<div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>перечень материалов</small></h2>
        <div class="clearfix"></div>
     </div>
<a class="btn btn-primary" href="/infodocs-materialsform">Добавить</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>id</th>
			<th>Cчет учета</th>
			<th>Код</th>
			<th>Группа</th>
			<th>Материал</th>
			<th>Единица измерения</th>
			<th>Действия</th>
		
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
		<td><?= $item->object->gruppa ?></td>
		<td><?= $item->object->material ?></td>
		<td><?= $item->object->izm ?></td>
		<td>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Действия
                </button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="/infodocs-materialsform?oinfodocsmaterials_id=<?=$item->object->id?>">Редактировать</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="/infodocs-materials?action=oinfodocsmaterials.delete.do&oinfodocsmaterials[id]=<?= $oFS->id ?>">Удалить</a>
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