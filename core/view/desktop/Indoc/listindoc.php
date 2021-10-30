<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where;
use RedCore\Users\Collection as Users;
use RedCore\Search\Collection as Search;
use RedCore\Request as Request;

$my_doc_status = Request::vars("my_doc_status");

Session::bind("filter_doc_types_id", "general_filter_doc_types_id", -1);
Session::bind("filter_doc_step_id", "general_filter_doc_step_id", -1);

$session_doctypes = (int) Session::get("general_filter_doc_types_id");
$session_doc_step = (int) Session::get("general_filter_doc_step_id");

Indoc::setObject("odoctypes");
$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();

$DocTypes_list = Indoc::getList($where);
$DocTypesid = array();
foreach ($DocTypes_list as $id => $temp) {
  $DocTypesid[$id] = $temp->object->id;
}

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
  $doc_steps_ready[$item->object->doc_id] = $item;
}

$doc_steps_name = Indoc::getRouteStatuses();
$doc_status_name = Indoc::GetNameStatuses();
$read_doc = Users::CanUserReadDocs($DocTypesid);

Users::setObject("user");
$user_id = Users::getAuthId();
$user_role = Users::getAuthRole();
$fio_user = Users::getList();

$user = Users::getRolesList();

if (!is_null($my_doc_status)) {
    foreach ($doc_steps as $key => $item) {
        $item = $item->object;
        if (0 != $item->user_id || 1 == $user_role || 2 == $user_role) {
            if ($user_id == $item->user_id || 1 == $user_role || 2 == $user_role) {
                if ($all_docs[$item->doc_id]->object->status == $my_doc_status) {
                    $items[$item->id]= $all_docs[$item->doc_id];
                    // $items[$item->id]["step"] = $item->step;
                    // $items[$item->id]["role"] = $item->role_id;
                    // $items[$item->id]["user_id"] = $item->user_id;
                }
            }
        } else {
            if ($user_role == $item->role_id || 1 == $user_role || 2 == $user_role) {
                if ($all_docs[$item->doc_id]->object->status == $my_doc_status) {
                    $items[$item->id] = $all_docs[$item->doc_id];
                    // $items[$item->id]["step"] = $item->step;
                    // $items[$item->id]["role"] = $item->role_id;
                    // $items[$item->id]["user_id"] = $item->user_id;
                }
            }
        }
    }
}

else {
    foreach ($all_docs as $item) {
        if ($read_doc[$item->object->params->doctypes]) {
            $items[] = $item;
        }
    }
}

if (-1 !== $session_doc_step) {
  foreach ($items as $document) {
    if ($doc_steps_name[$doc_steps_ready[$document->object->id]->object->step] == $session_doc_step) {
      $tmp[] = $document;
    }
  }
  $items = $tmp;
}
if (-1 !== $session_doctypes) {
  foreach ($items as $document) {
    if ($document->object->params->doctypes == $session_doctypes) {
      $tmp[] = $document;
    }
  }
  $items = $tmp;
}
// Search::setObject("osearch");
// Search::export($items);
?>
<?
require 'listindoc.filter.php';
?>
<a class="btn btn-primary" href="/indocitems-form-addupdate">ДОБАВИТЬ</a>

<table border=1 id="datatable" class="table table-striped table-bordered" style="width: 100%">
  <thead>
    <tr>
      <th>Имя документа</th>
      <th>№ Регистрации</th>
      <th>Назначено</th>
      <th>Прогресс</th>
      <th>Статус</th>
      <th>Действие</th>
    </tr>
  </thead>
  <tbody>

    <?
    foreach ($items as $key => $item) :
    ?>
        <tr>
          <td>
            <a><?= $item->object->name_doc ?></a>
            <br>
            <small><b><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></b></small>
            (
            <small><?= $item->object->reg_date ?></small>
            )
          </td>
          <td><?= $item->object->reg_number ?></td>
          <td>
            <ul class="list-inline">
              <li>
                <img src="<?= ICONS . SEP . 'user.png' ?>" class="avatar" alt="Avatar" title="
					<?= $user[$doc_steps_ready[$item->object->id]->object->role_id] ?> <?= $fio_user[$doc_steps_ready[$item->object->id]->object->user_id]->object->params->f ?> <?= $fio_user[$doc_steps_ready[$item->object->id]->object->user_id]->object->params->i ?>">
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
          <td><button type="button" class="btn btn-success btn-sm"><?= $doc_status_name[$item->object->status] ?></button></td>
          <td><a href="/indocitems-form-view?oindoc_id=<?= $item->object->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> Просмотреть </a>
            <? if (Indoc::CanUserEditDocs($item->object->id, $user_role, $user_id)) : ?>
              <a href="/indocitems-form-addupdate?oindoc_id=<?= $item->object->id ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Редактировать </a>
            <? endif; ?>
            <? if($item->object->status == 5 || $item->object->status == 6) : ?>
              <a class="btn btn-info" href = "/docs-download?oindoc_id=<?= $item->object->id ?>">Скачать документ</a>
            <? endif; ?>
            <a href="/indocitems-form-delete?oindoc_id=<?= $item->object->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Удалить </a>
          </td>
        </tr>


    <?
    // endif;
    // endif;
    endforeach;
    ?>
  </tbody>
</table>