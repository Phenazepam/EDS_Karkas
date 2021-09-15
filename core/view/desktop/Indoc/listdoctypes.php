<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;


Indoc::setObject("odoctypes");

$where = Where::Cond()
->add("_deleted", "=", "0")
->parse();

$items = Indoc::getList($where);

?>

<a class="btn btn-primary" href="/doctypes-form">Добавить</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>№ П/п</th>
			<th>Тип документа</th>
			<th>Действие</th>
		</tr>
	</thead>
	<tbody>

		<?
		$i = 0;
		foreach ($items as $item) :
			$i++;
		?>

			<tr>
				<td><?= $i ?></td>
				<td><?= $item->object->title ?></td>
				<td>
					<div class="btn-group btn-group-sm">
						<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Действия
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="/doctypes-form?odoctypes_id=<?= $item->object->id ?>">Редактировать</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="/doctypes-form-delete?odoctypes_id=<?= $item->object->id ?>">Удалить</a>
						</div>
					</div>
				</td>
			</tr>

		<?
		endforeach;

		?>
	</tbody>
</table>