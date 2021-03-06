<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where;
use RedCore\Users\Collection as Users;
use RedCore\Search\Collection as Search;
use RedCore\Request as Request;
use RedCore\Config as Config;


$my_doc_status = Request::vars("my_doc_status");
$indoc_status = Request::vars("indoc_status");

Session::bind("filter_year_id",          "general_filter_year_id", (date("Y") - Config::$begin_year + 1));
Session::bind("filter_month_id",         "general_filter_month_id", date("m"));
Session::bind("filter_doc_types_id", "general_filter_doc_types_id", -1);
Session::bind("filter_doc_step_id", "general_filter_doc_step_id", -1);

$session_year = (int)Session::get("general_filter_year_id");
$session_month = (int)Session::get("general_filter_month_id");
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
$user_roles = Users::getRolesList();

/*
 * Фильтр по "Мои документы" и "Входящие"
 */
if (!is_null($my_doc_status)) {
  $documents = Indoc::GetMyDocs($user_id, $my_doc_status);
  if ($my_doc_status == 6 || $my_doc_status == 5) {
    $documents = Indoc::GetApprovedDocs();
  }
}
else if (!is_null($indoc_status)) {
  $documents = Indoc::GetInDocs($user_id, $user_role, $indoc_status);
}
else {
  foreach ($all_docs as $item) {
    if ($read_doc[$item->object->params->doctypes]) {
      $documents[] = $item;
    }
  }
}

Indoc::setObject('odocfile');
$where = Where::Cond()
->add("_deleted", "=", "0")
->add("and")
->add("iscurrent", "=", "1")
->parse();
$files = Indoc::getList($where);
foreach($files as $file) {
  $tmp[$file->object->doc_id] = $file;
}
$files = $tmp;

$headers_for_excel = array('№ Регистрации', 'Имя документа', 'Тип документа', 'Дата создания', 'Статус', 'Прогресс');
$i = 0;
foreach ($documents as $item) {
  $items_for_excel[$i][0] =  $item->object->reg_number;
  $items_for_excel[$i][1] =  $item->object->name_doc;
  $items_for_excel[$i][2] =  $DocTypes_list[$item->object->params->doctypes]->object->title;
  $items_for_excel[$i][3] =  $item->object->reg_date;
  $items_for_excel[$i][4] =  $doc_status_name[$item->object->status];
  $items_for_excel[$i][5] =  Indoc::GetProgressPercent($item->object->id).'%';
  $i++;
}
Session::set('s_excel_items', $items_for_excel);
Session::set('s_excel_headers', $headers_for_excel);
/*
 * Фильтр по Статусу
 */
$tmp = array();

if (-1 !== $session_doc_step) {
    foreach ($all_docs as $document) {
        if ($document->object->status == $session_doc_step) {
            $tmp[] = $document;
        }
    }
    $documents = $tmp;
}
/*
 * Фильтр по Типу документа
 */
$tmp = array();

if (-1 !== $session_doctypes) {
    foreach ($all_docs as $document) {
        if ($document->object->params->doctypes == $session_doctypes) {
            $tmp[] = $document;
        }
    }
    $documents = $tmp;
}

$tmp = array();


?>



<?
require 'listindoc.filter.php';
?>
<a class="btn btn-primary" href="/indocitems-form-addupdate">ДОБАВИТЬ</a>
<a class="btn btn-primary" href="/excel-download">Выгрузка</a>

<table border=1 id="datatable1" class="table table-striped table-bordered" style="width: 100%">
  <thead>
    <tr>
      <th style="display: none;">Дата Регистрации</th>
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
    foreach ($documents as $key => $item) :
    ?>
        <tr>
          <td style="display: none;"><?= date('Y-m-d', strtotime($item->object->reg_date)) /* */?></td>
          <td>
            <a><?= $item->object->name_doc ?></a>
            <br>
            <small><b><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></b></small>
            (<small><?=$item->object->reg_date?></small>)
          </td>
          <td><?= $item->object->reg_number ?></td>
          <td>
            <ul class="list-inline">
            <? $doc_id = $item->object->id;
            $t = Users::GetDocRoute($item->object->params->doctypes, $doc_id);
            foreach ($t as $key => $value) :
            if (1 == $value["iscurrent"]) {
                $icon = ICONS . SEP . 'user_responsible.png';
            } 
            else {
                $icon = ICONS . SEP . 'user.png';
            }
            ?>
                	<li>
                		<img src="<?= $icon ?>" class="avatar" alt="Avatar" title="
                            <?= $user_roles[$value['role']]?> <?= Users::getUserNameById($value['user_id']) ?>">
					</li>
           <?
            endforeach;
           ?>
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
          <td><?= $doc_status_name[$item->object->status] ?></td>
          <td><a href="/indocitems-form-view?oindoc_id=<?= $item->object->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> Просмотреть </a>
            <? if (Indoc::CanUserEditDocs($item->object->id, $user_role, $user_id)) : ?>
              <a href="/indocitems-form-addupdate?oindoc_id=<?= $item->object->id ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Редактировать </a>
            <? endif; ?>
            <? if(($item->object->status == 5 || $item->object->status == 6) 
                && isset($files[$item->object->id])) : ?>
              <a class="btn btn-info btn-sm" href = "/docs-download?file_id=<?= $files[$item->object->id]->object->id ?>">Скачать документ</a>
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
<script src="/template/general/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script>
  jQuery(document).ready(function() {
    $('#datatable1').dataTable( {
      "ordering" : true,
      "order": [ 0, 'desc' ]
    } );
  });
</script>