<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;
use RedCore\Users\Collection as Users;

Users::setObject("user");
$user_role = Users::getAuthRole();
$user_id = Users::getAuthId();

Indoc::setObject("odoctypes");
$where = Where::Cond()
->add("_deleted", "=", "0")
->parse();

$DocTypes_list = Indoc::getList($where);

Indoc::setObject("oindoc");

$where = Where::Cond()
->add("_deleted", "=", "0")
->parse();

$all_docs = Indoc::getList($where);

Indoc::setObject('odocroute');
$where = Where::Cond()
->add("_deleted", "=", "0")
->add("and")
->add("iscurrent", "=", "1")
->parse();
$doc_steps = Indoc::getList($where);

foreach ($doc_steps as $key => $item) {
    $item = $item->object;
    if (0 != $item->user_id || 1 == $user_role || 2 == $user_role) {
        if ($user_id == $item->user_id || 1 == $user_role || 2 == $user_role) {
            $docs_array[$item->id]["data"] = $all_docs[$item->doc_id];
            $docs_array[$item->id]["step"] = $item->step;
            $docs_array[$item->id]["role"] = $item->role_id;
            $docs_array[$item->id]["user_id"] = $item->user_id;
        }
    } else {
        if ($user_role == $item->role_id || 1 == $user_role || 2 == $user_role) {
            $docs_array[$item->id]["data"] = $all_docs[$item->doc_id];
            $docs_array[$item->id]["step"] = $item->step;
            $docs_array[$item->id]["role"] = $item->role_id;
            $docs_array[$item->id]["user_id"] = $item->user_id;
        }
    }
}
$doc_steps_name = Indoc::getRouteStatuses();

Users::setObject("user");

$fio_user = Users::getList();

$user = Users::getRolesList();

?>

<a class="btn btn-primary" href="/indocitems-form-addupdate">ДОБАВИТЬ</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
  <thead>
		<tr>
			<th>Имя документа</th>
			<th>№ Регистрации</th>
			<th>Назначено</th>
			<th>Прогресс</th>
			<th>Шаг</th>
			<th>Действие</th>
		</tr>
	</thead>
  <tbody>

    <?
    foreach ($docs_array as $tmp) :
      if ($tmp["step"] == 4) :
        $item = $tmp["data"];
    ?>

         <tr>
			<td>
			<a><?= $item->object->name_doc ?></a>
			<br>
			<small><b><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></b></small>
			<br>
			<small><?= $item->object->reg_date ?></small>
			</td>
			<td><?= $item->object->reg_number ?></td>
			<td>
				<ul class="list-inline">
					<li>
						<img src="<?= ICONS . SEP . 'user.png' ?>" class="avatar" alt="Avatar" title="
                            <?= $user[$tmp["role"]] ?>
                            <?= $fio_user[$tmp["user_id"]]->object->params->f ?>
                            <?= $fio_user[$tmp["user_id"]]->object->params->i ?>">
            		</li>
            	</ul>
            </td>
            <td class="project_progress">
                            <div class="progress progress_sm">
                              <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="57" style="width: 57%;" aria-valuenow="56"></div>
                            </div>
                            <small>57% Complete</small>
                          </td>
            <td><button type="button" class="btn btn-success btn-xs"><?= $doc_steps_name[$tmp["step"]] ?></button></td>          
          <td><a href="/indocitems-form-view?oindoc_id=<?= $item->object->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Просмотреть </a>
          	<? if (Indoc::CanUserEditDocs($item->object->id, $user_role, $user_id)) : ?>
              <a href="/indocitems-form-addupdate?oindoc_id=<?= $item->object->id ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Редактировать </a>
            <? endif; ?>
              <a href="/indocitems-form-delete?oindoc_id=<?= $item->object->id ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Удалить </a>
          </td>
		</tr>
    <?
      endif;
    endforeach;
    ?>
  </tbody>
</table>