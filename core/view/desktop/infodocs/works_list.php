<?php

use \RedCore\Infodocs\Collection as Works;
use \RedCore\Where as Where;

Works::setObject("oinfodocsworks");
$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();
$items = Works::getList($where);

?>
	<div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>перечень работ</small></h2>
        <div class="clearfix"></div>
     </div>
	 
<a class="btn btn-primary" href="/infodocs-worksform">Добавить</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>id</th>
			<th>Группа</th>
			<th>Имя</th>
			<th>Измерение</th>
			<th>Краснодар</th>
			<th>Ростов-на-Дону</th>
			<th>Владивосток</th>
			<th>Объект 1</th>
			<th>Объект 2</th>
			<th>Объект 3</th>
			<th>Объект 4</th>
		
		</tr>
	</thead>
	<tbody>

<?
    foreach($items as $item):
?>

	<tr>
		<td><?= $item->object->id ?></td>
		<td><?= $item->object->gruppa ?></td>
		<td><?= $item->object->name ?></td>
		<td><?= $item->object->izm ?></td>
		<td><?= $item->object->krd ?></td>
		<td><?= $item->object->rnd ?></td>
		<td><?= $item->object->vldvstk ?></td>
		<td><?= $item->object->obj1 ?></td>
		<td><?= $item->object->obj2 ?></td>
		<td><?= $item->object->obj3 ?></td>
		<td><?= $item->object->obj4 ?></td>
		<td>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Действия
                </button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="/infodocs-worksform?oinfodocsworks_id=<?=$item->object->id?>">Редактировать</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="/infodocs-works?action=oinfodocsworks.delete.do&oinfodocsworks[id]=<?= $item->object->id ?>">Удалить</a>
				</div>
            </div>
        </td>
	</tr>
	
<?
endforeach;	

?>
</tbody>
</table>