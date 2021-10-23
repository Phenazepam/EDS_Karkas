<?php

use RedCore\Session;
use \RedCore\Users\Collection as Users;
use \RedCore\Where as Where;

Users::setObject("user");

$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();

$items = Users::getList($where);
// TmpExcel::setDateTable($headers, $items); //--------->
// $resul_array = array(
//   'headers' => $headers,
//   'items' => $items
// );
// Session::set('excelDataTable', $resul_array)
?>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>ПОЛЬЗОВАТЕЛИ<small>реестр записей</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">

              <a class="btn btn-primary" href="/users-form">Добавить <i class="fa fa-plus"></i></a>
              <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>№ п/п</th>
                    <th>ФИО</th>
                    <th>Роль</th>
                    <th>Логин</th>
                    <th>Действия</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i =  1;
                  foreach ($items as $key => $item) :
                    $oFS = $item->getFieldSet("users-list");
                  ?>
                    <tr>
                      <td><?= $i++ ?></td>
                      <td><?= $oFS->f ?> <?= $oFS->i ?> <?= $oFS->o ?></td>
                      <td><?= Users::getRoleById($oFS->role) ?></td>
                      <td><?= $oFS->login ?></td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Действия
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="/users-form?user_id=<?= $oFS->id ?>">Редактировать</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/users-list?action=user.delete.do&user[id]=<?= $oFS->id ?>">Удалить</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php
                  endforeach;
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>