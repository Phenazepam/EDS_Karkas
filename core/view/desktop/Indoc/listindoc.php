<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where;
use RedCore\Users\Collection as Users;
use RedCore\Search\Collection as Search;

Session::bind("filter_doc_types_id",      "general_filter_doc_types_id", -1);

$session_doctypes      = (int)Session::get("general_filter_doc_types_id");

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
$items = Indoc::getList($where);

$tmp = array();

foreach($items as $document) {
    if($document->object->params->doctypes == $session_doctypes){
        $tmp[]=$document;
    }
}

$items = $tmp;

$edit_doc = Indoc::CanUserEditDocs();



Indoc::setObject('odocroute');
$where = Where::Cond()
->add("_deleted", "=", "0")
->parse();
$doc_steps = Indoc::getList($where);

foreach ($doc_steps as $key => $item) {
    $doc_steps_ready[$item->object->doc_id] = $item;
}
$doc_steps_name = Indoc::getRouteStatuses();

Users::setObject("user");

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

<table border=1 id="datatable" class="table table-striped table-bordered" style="width:100%">
  <thead>
    <tr>
      <th>Тип документа</th>
      <th>Имя документа</th>
      <th>№ Регистрации</th>
      <th>Дата регистрации</th>
      <th>Назначено</th>
      <th>Шаг</th>
      <th>Файл</th>
      <th>Действие</th>
    </tr>
  </thead>
  <tbody>

    <?
    foreach ($items as $item) :
      if ($read_doc[$item->object->params->doctypes]) :

    ?>

        <tr>
          <td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
          <td><?= $item->object->name_doc ?></td>
          <td><?= $item->object->reg_number ?></td>
          <td><?= $item->object->reg_date ?></td>
          <td><?= $user[$doc_steps_ready[$item->object->id]->object->role_id]?> 
          <?= $fio_user[$doc_steps_ready[$item->object->id]->object->user_id]->object->params->f?> 
          <?= $fio_user[$doc_steps_ready[$item->object->id]->object->user_id]->object->params->i?></td>
          <td><?=$doc_steps_name[$doc_steps_ready[$item->object->id]->object->step]?></td>
          <?
          if (!empty($item->object->params->file_title)) {
          ?>
            <td><img src="<?= ICONS . SEP . 'doc.png' ?>"></td>
          <?
          } else {
          ?>
            <td><img src="<?= NO_IMAGE ?>" width="100" height="67"></td>
          <?
          }
          ?>
          <td>
            <div class="btn-group btn-group-sm">
              <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Действия
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="/indocitems-form-view?oindoc_id=<?= $item->object->id ?>">Просмотреть</a>
                <? if ($edit_doc[$item->object->id]) : ?>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/indocitems-form-addupdate?oindoc_id=<?= $item->object->id ?>">Редактировать</a>
                <? endif; ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/indocitems-form-delete?oindoc_id=<?= $item->object->id ?>">Удалить</a>
              </div>
            </div>
          </td>
        </tr>


    <?
      endif;
    endforeach;
    ?>
  </tbody>
</table>