<?php

use \RedCore\Infodocs\Collection as Agents;
use \RedCore\Where as Where;

Agents::setObject("oinfodocsagents");
$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();
$items = Agents::getList($where);
?>
<script src="/core/view/desktop/Excel/UploadFile.js"></script>
	<div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>перечень контрагентов/корреспондентов</small></h2>
        <div class="clearfix"></div>
    </div>
<a class="btn btn-primary" href="/infodocs-agentsform">Добавить</a>
<button class="btn btn-primary" onclick="ShowModalForUpload('agents')">Загрузить данные из файла</button>
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
		<td><?= $item->object->inn ?></td>
		<td><?= $item->object->group_ka ?></td>
		<td><?= $item->object->material ?></td>
		<td><?= $item->object->main_worker ?></td>
		<td><?= $item->object->other ?></td>
		<td>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Действия
                </button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="/infodocs-agentsform?oinfodocsagents_id=<?=$item->object->id?>">Редактировать</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="/infodocs-agents?action=oinfodocsagents.delete.do&oinfodocsagents[id]=<?= $item->object->id ?>">Удалить</a>
				</div>
            </div>
        </td>
		
		
		<!--<td><a class="badge badge-primary" href="/infodocs-agentsform?oinfodocsagents_id=<?=$item->object->id?>">Редактировать</a></td>-->
	</tr>
<?
endforeach;	
?>
</tbody>
</table>