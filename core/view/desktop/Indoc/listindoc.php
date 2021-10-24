<?php
use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where;
use RedCore\Users\Collection as Users;
use RedCore\Search\Collection as Search;

Session::bind("filter_doc_types_id", "general_filter_doc_types_id", - 1);
Session::bind("filter_doc_step_id", "general_filter_doc_step_id", - 1);

$session_doctypes = (int) Session::get("general_filter_doc_types_id");
$session_doc_step = (int) Session::get("general_filter_doc_step_id");

Indoc::setObject("odoctypes");
$where = Where::Cond()->add("_deleted", "=", "0")->parse();

$DocTypes_list = Indoc::getList($where);
$DocTypesid = array();
foreach ($DocTypes_list as $id => $temp) {
    $DocTypesid[$id] = $temp->object->id;
}

Indoc::setObject("oindoc");

$where = Where::Cond()->add("_deleted", "=", "0")->parse();
$items = Indoc::getList($where);

$tmp = array();

if (- 1 !== $session_doctypes) {
    foreach ($items as $document) {
        if ($document->object->params->doctypes == $session_doctypes) {
            $tmp[] = $document;
        }
    }
    $items = $tmp;
}

Indoc::setObject('odocroute');
$where = Where::Cond()->add("_deleted", "=", "0")->parse();
$doc_steps = Indoc::getList($where);

foreach ($doc_steps as $key => $item) {
    $doc_steps_ready[$item->object->doc_id] = $item;
}

$doc_steps_name = Indoc::getRouteStatuses();

if (- 1 !== $session_doc_step) {
    foreach ($items as $document) {
        if ($doc_steps_name[$doc_steps_ready[$document->object->id]->object->step] == $session_doc_step) {
            $tmp[] = $document;
        }
    }
    $items = $tmp;
}

Users::setObject("user");
$user_id = Users::getAuthId();
$user_role = Users::getAuthRole();
$fio_user = Users::getList();

$user = Users::getRolesList();

$read_doc = Users::CanUserReadDocs($DocTypesid);

Search::setObject("osearch");
Search::export($items);

?>
<?
require 'listindoc.filter.php';
?>
<a class="btn btn-primary" href="/indocitems-form-addupdate">ДОБАВИТЬ</a>

<table border=1 id="datatable"
	class="table table-striped table-bordered" style="width: 100%">
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
    foreach ($items as $item) :
        if ($read_doc[$item->object->params->doctypes]) :
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
						<?= $user[$doc_steps_ready[$item->object->id]->object->role_id] ?>
            			<?= $fio_user[$doc_steps_ready[$item->object->id]->object->user_id]->object->params->f ?>
            			<?= $fio_user[$doc_steps_ready[$item->object->id]->object->user_id]->object->params->i ?>">
            		</li>
            	</ul>
            </td>
            <td class="project_progress">
              <?php
                $prc = Indoc::GetProgressPercent($item->object->id);
              ?>
                            <div class="progress progress_sm">
                              <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?= $prc ?>" style="width: 57%;" aria-valuenow="56"></div>
                            </div>
                            <small><?= $prc ?>% Пройдено</small>
                          </td>
            <td><button type="button" class="btn btn-success btn-xs"><?= $doc_steps_name[$doc_steps_ready[$item->object->id]->object->step] ?></button></td>          
          <td><a href="/indocitems-form-view?oindoc_id=<?= $item->object->id ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Просмотреть </a>
          	<? if (Indoc::CanUserEditDocs($item->object->id, $user_role, $user_id)) : ?>
              <a href="/indocitems-form-addupdate?oindoc_id=<?= $item->object->id ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Редактировать </a>
            <? endif; ?>
              <a href="/indocitems-form-delete?oindoc_id=<?= $item->object->id ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Удалить </a>
          </td>
		</tr>


    <?
      endif;

    endforeach
    ;
    ?>
  </tbody>
</table>