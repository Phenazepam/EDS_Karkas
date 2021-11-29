<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Request;
use RedCore\Where;
use RedCore\Users\Collection as Users;
use RedCore\Session as Session;

Indoc::setObject("oindoc");

$action = Indoc::getActionDoc();


$fist_page = 'active';
if (Request::vars("view") !== null) {
  $view = 'active';
  $fist_page = '';
}



$lb_params = array(
  "id" => Request::vars("oindoc_id")
);

$item = Indoc::loadBy($lb_params);

Indoc::setObject("odoctypes");

$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();

$DocTypes_list = Indoc::getList($where);

$doc_steps = Indoc::getRouteStatuses();

$user_roles = Users::getRolesList();

Indoc::setObject("odoclog");

$log = Where::Cond()
    ->add("doc_id", "=", $item->object->id)
    ->parse();

$doclog = Indoc::getList($log);

$docStatus = Indoc::getStatuslist();

Users::setObject("user");
$user_id = Users::getAuthId();
$user_role = Users::getAuthRole();
$fio_user = Users::getList();

$doc_id = $item->object->id;
$doc_type = $item->object->params->doctypes;

Indoc::setObject('odocroute');
$lb_params = array(
  'doc_id' => $doc_id,
  'iscurrent' => '1'
);
$current_route_step = Indoc::loadBy($lb_params);
$current_step_order = $current_route_step->object->step_order;
$current_role = $current_route_step->object->role_id;
$current_step = $current_route_step->object->step;

Indoc::setObject('odocfile');
$lb_params = array(
  'doc_id' => $doc_id,
  'iscurrent' => '1'
);
$doc_file = Indoc::loadBy($lb_params);
$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->add("and")
  ->add("doc_id", "=", $doc_id)
  ->parse();
$all_files = Indoc::getList($where);

?>
<script src="/core/view/desktop/Indoc/js/popupMovingRoute.js"></script>
<script src="/core/view/desktop/Indoc/js/saveDocViewEvent.js"></script>
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <div class="clearfix">
                <h2><b><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?>:</b> <?= $item->object->name_doc ?></h2>
        </div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
              <div class="row">
                <div class="col">
                </div>
                <div class="col"> 
                </div>
              </div>
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?=$fist_page?>" id="home-tab" 
                      data-toggle="tab" href="#home" role="tab" 
                      aria-controls="home" aria-selected="true">
                    Маршрут документа</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$view?>" id="profile-tab" 
                      data-toggle="tab" href="#profile" role="tab" 
                      aria-controls="profile" aria-selected="false"
                      onclick="saveDocViewEvent(<?=$doc_id?>, <?=$user_id?>)">
                    Просмотр</a>
                </li>
                <? if (1 == $user_role || 2 == $user_role): ?>
                <li class="nav-item">
                    <a class="nav-link" id="files-tab" 
                      data-toggle="tab" href="#files" role="files" 
                      aria-controls="files" aria-selected="false">
                    История изменения файлов</a>
                </li>
                <?endif?>
              </ul>
              <div class="tab-content">
                <div class="tab-pane <?=$fist_page?>" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="alert alert-info alert-dismissible " role="alert">
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Подсказка.</strong>  Чтобы направить документ далее перейдите во вкладку "Просмотр".
                  </div>
                  <div class="row">
                    <div class="col-5">
                      <table border=1 id="" class="table table-bordered" style="width: 100%">
                        <thead>
                          <tr>
                            <th>Шаг №</th>
                            <th>Роль</th>
                            <th>Статус</th>
                            <th>Ответственный</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $t = Users::GetDocRoute($item->object->params->doctypes, $doc_id);
                          foreach ($t as $key => $value) :
                            if (1 == $value["iscurrent"]) {
                              $current = "current";
                            } 
                            else {
                              $current = "path";
                            }

                          ?>
                            <tr class="<?= $current ?>">
                              <td><?= $key ?></td>
                              <td><?= $user_roles[$value['role']] ?></td>
                              <td><?= $doc_steps[$value['step']] ?></td>
                              <td><?= Users::getUserNameById($value['user_id']) ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-7">
                      <table border=1 id="" class="table table-bordered" style="width: 100%">
                        <thead>
                         <? if (Users::CanUserSeeDocLog($user_role)) : ?>
                          <tr>
                            <th>Резолюция</th>
                          </tr>
                          <tr>
                            <th>Действие</th>
                            <th>Пользователь</th>
                            <th>Комментарий</th>
                            <th>Дата и время</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?
                          foreach ($doclog as $log) :
                          ?>
                          <tr>
                            <td><?= $action[$log->object->action] ?></td>
                            <td><?= $fio_user[$log->object->user_id]->object->params->f ?> <?=$fio_user[$log->object->user_id]->object->params->i?></td>
                            <td><?= $log->object->comment ?></td>
                            <td><?= $log->object->_updated ?></td>
                          </tr>
                          <?
                          endforeach;
                          endif;
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <a class="btn btn-danger" href="/indocitems-list">Отмена</a>
                </div>
                <div class="tab-pane <?=$view?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <table border=1 id="datatable1" class="table table-striped table-bordered" style="width: 100%">
                    <tbody>
                      <tr>
                        <td><b>Тип документа</b></td>
                        <td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
                      </tr>
                      <tr>
                        <td><b>Имя документа</b></td>
                        <td><?= $item->object->name_doc ?></td>
                      </tr>
                      <tr>
                        <td><b>№ Регистрации</b></td>
                        <td><?= $item->object->reg_number ?></td>
                      </tr>
                      <tr>
                        <td><b>Дата регистрации</b></td>
                        <td><?= $item->object->reg_date ?></td>
                      </tr>
                      <tr>
                        <td><b>Статус документа</b></td>
                        <td><?= $docStatus[$item->object->status] ?></td>
                      </tr>
                      <tr>
                        <td><b>Файл</b></td>
                        <td>
                        <? if (!empty($doc_file->object->id)): ?>
                          <p><b><?=$doc_file->object->name?> от <?=date('d.m.Y', strtotime($doc_file->object->_updated))?></b></p>
                        <a class="btn btn-info btn-sm" href = "/docs-download?file_id=<?= $doc_file->object->id ?>">Скачать документ</a>
                        <? endif; ?>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td><b>Связанные документы</b></td> -->
                        <td colspan="2">
                        <?php 
                          Session::set("s_relateddoc_id", $item->object->id);
                          $relateddocs = require('RelatedDocView/generateRelatedDocView.php'); 
                          Session::delete("s_relateddoc_id");
                        ?>
                          <?= $relateddocs ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <? if (Indoc::CanUserEditDocs($doc_id, $user_role, $user_id)):?>
                  <a class="btn btn-primary" href="/indocitems-form-addupdate?oindoc_id=<?= $doc_id ?>">Редактировать</a>
                  <? endif;?>
                  <?php 
                    if(Users::CanUserMoveRoute($doc_id, $current_role, $current_step)):
                  ?>
                   <button class="btn btn-primary" onclick="popupMovingRoute(<?= $doc_id ?> )">
                    <?=Users::GetMoveRouteButtonName($doc_type, $current_step_order)?>
                  </button>
                  <? endif; ?>
                  <?php if(Users::CanUserMoveRouteBack($doc_id)
                    && !Users::IsFirstStep($doc_type, $current_step_order)):?>
                   <button class="btn btn-primary" onclick="popupMovingRoute(<?= $doc_id ?>, 1)">
                    Вернуть на доработку
                  </button>
                  <? endif;?>
                  <a class="btn btn-danger" href="/indocitems-list">Отмена</a>
                </div>
                <div class="tab-pane" id="files" role="tabpanel" aria-labelledby="files-tab">
                  <div class="row">
                    <div class="col">
                      <table class="table table-bordered" style="width: 100%">
                        <thead>
                          <tr>
                            <th>Наименование файла</th>
                            <th>Дата загрузки</th>
                            <th>Загружен пользователем</th>
                            <th>Текущий</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          
                          foreach ($all_files as $key => $value) :
                            $value=$value->object;
                          ?>
                            <tr class="<?= $value->iscurrent == 1 ? 'current' : '' ?>">
                              <td>
                                <a href = "/docs-download?file_id=<?= $value->id ?>">
                                  <?= $value->name ?>
                                </a>
                              </td>
                              <td><?= $value->_updated ?></td>
                              <td><?= Users::getUserNameById($value->uploadedbyuser) ?></td>
                              <td><?= $value->iscurrent == 1 ? 'Да' : 'Нет' ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <a class="btn btn-danger" href="/indocitems-list">Отмена</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <script src="../../../../template/general/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script> -->
<style>
  .current {
    background-color: lightblue;
    font-weight: bold;
  }
  .path {
    color: rgba(0,0,0,0.5);
  }
</style>