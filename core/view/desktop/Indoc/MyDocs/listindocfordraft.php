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
      <th>Тип документа</th>
      <th>Имя документа</th>
      <th>№ Регистрации</th>
      <th>Дата регистрации</th>
      <th>Назначенно на</th>
      <th>Шаг</th>
      <th>Файл</th>
      <th>Действие</th>
    </tr>
  </thead>
  <tbody>

    <?
    foreach ($docs_array as $tmp) :
      if ($tmp["step"] == 1) :
        $item = $tmp["data"];
    ?>

        <tr>
          <td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
          <td><?= $item->object->name_doc ?></td>
          <td><?= $item->object->reg_number ?></td>
          <td><?= $item->object->reg_date ?></td>
          <td><?= $user[$tmp["role"]] ?>
            <?= $fio_user[$tmp["user_id"]]->object->params->f ?>
            <?= $fio_user[$tmp["user_id"]]->object->params->i ?></td>
          <td><?= $doc_steps_name[$tmp["step"]] ?></td>
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
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/indocitems-form-addupdate?oindoc_id=<?= $item->object->id ?>">Редактировать</a>
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