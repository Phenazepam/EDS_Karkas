<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where;
use RedCore\Users\Collection as Users;
use RedCore\Search\Collection as Search;
use RedCore\Request as Request;
use RedCore\Infodocs\Collection as Infodocs;

$doc_id = Request::vars("doc_id");

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


Indoc::setObject('odocroute');
$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();
$doc_steps = Indoc::getList($where);

foreach ($doc_steps as $key => $item) {
  if (!is_null($item->object->id)) {
    $doc_steps_ready[$item->object->doc_id] = $item;
  }
}
$doc_steps_name = Indoc::getRouteStatuses();

Infodocs::setObject("oinfodocsagents");
$info_agents = Infodocs::getList($where);

Infodocs::setObject("oinfodocsworks");
$info_works = Infodocs::getList($where);

Infodocs::setObject("oinfodocsmaterials");
$info_materials = Infodocs::getList($where);

Infodocs::setObject("oinfodocsstandarts");
$info_standarts = Infodocs::getList($where);

Users::setObject('user');
$users = Users::getList($where);
$user_roles = Users::getRolesList();

?>
<link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link href="/template/general/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script src="/template/general/vendors/jquery/dist/jquery.min.js"></script>
<script src="/template/general/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" 
      href="#home" role="tab" aria-controls="home" 
      aria-selected="true">
      Документы</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="agents-tab" data-toggle="tab" 
      href="#agents" role="tab" aria-controls="agents" 
      aria-selected="false">
      Контрагенты</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="works-tab" 
    data-toggle="tab" href="#works" role="tab" 
    aria-controls="works" aria-selected="false">
      Виды работ</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="materials-tab" data-toggle="tab" 
    href="#materials" role="tab" aria-controls="materials" 
    aria-selected="false">
      Материалы</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="standarts-tab" data-toggle="tab" href="#standarts" 
    role="tab" aria-controls="standarts" aria-selected="false">
      Нормы</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" 
    role="tab" aria-controls="users" aria-selected="false">
      Ответственный</a>
  </li>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <table id="datatableForRelated" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Тип документа</th>
          <th>Имя документа</th>
          <th>№ Регистрации</th>
          <th>Дата регистрации</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <? foreach ($items as $item) :?>
          <tr>
            <td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
            <td><?= $item->object->name_doc ?></td>
            <td><?= $item->object->reg_number ?></td>
            <td><?= $item->object->reg_date ?></td>
            <td>
              <a class="btn btn-secondary" style="cursor: pointer; color: white;" 
                href="/indocitems-form-addupdate?action=relateddoc.addrelateddoc.do&
                relateddoc[doc_id]=<?= $doc_id ?>&
                relateddoc[relateddoc_id]=<?= $item->object->id ?>&
                relateddoc[type]=1">Связать</a>
            </td>
          </tr>
        <?endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="tab-pane" id="agents" role="tabpanel" aria-labelledby="agents-tab">
    <table id="datatableForRelatedAgents" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Наименование</th>
          <th>Инн</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        <?
        foreach ($info_agents as $item) :

        ?>
          <tr>
            <td><?= $item->object->name ?></td>
            <td><?= $item->object->inn ?></td>
            <td>
              <a class="btn btn-secondary" style="cursor: pointer; color: white;" 
                href="/indocitems-form-addupdate?action=relateddoc.addrelateddoc.do&
                relateddoc[doc_id]=<?= $doc_id ?>&
                relateddoc[relateddoc_id]=<?= $item->object->id ?>&
                relateddoc[type]=2">Связать</a>
            </td>
          </tr>
        <?

        endforeach;
        ?>
      </tbody>
    </table>
  </div>
  <div class="tab-pane" id="works" role="tabpanel" aria-labelledby="works-tab">
    <table id="datatableForRelatedWorks" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Группа</th>
          <th>Наименование</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?foreach ($info_works as $item) :?>
          <tr>
          <td><?= $item->object->gruppa ?></td>
          <td><?= $item->object->name ?></td>
            <td>
              <a class="btn btn-secondary" style="cursor: pointer; color: white;" 
                href="/indocitems-form-addupdate?action=relateddoc.addrelateddoc.do&
                relateddoc[doc_id]=<?= $doc_id ?>&
                relateddoc[relateddoc_id]=<?= $item->object->id ?>&
                relateddoc[type]=3">Связать</a>
            </td>
          </tr>
        <?endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="tab-pane" id="materials" role="tabpanel" aria-labelledby="materials-tab">
    <table id="datatableForRelatedMaterials" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Счет учета</th>
          <th>Код</th>
          <th>Группа</th>
          <th>Материал</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?foreach ($info_materials as $item) :?>
          <tr>
          <td><?= $item->object->su ?></td>
          <td><?= $item->object->code ?></td>
          <td><?= $item->object->gruppa ?></td>
          <td><?= $item->object->material ?></td>
            <td>
              <a class="btn btn-secondary" style="cursor: pointer; color: white;" 
                href="/indocitems-form-addupdate?action=relateddoc.addrelateddoc.do&
                relateddoc[doc_id]=<?= $doc_id ?>&
                relateddoc[relateddoc_id]=<?= $item->object->id ?>&
                relateddoc[type]=4
                ">Связать</a>
            </td>
          </tr>
        <?endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="tab-pane" id="standarts" role="tabpanel" aria-labelledby="standarts-tab">
    <table id="datatableForRelatedStandarts" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Наименование</th>
          <th>ед. изм.</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?foreach ($info_standarts as $item) :?>
          <tr>
            <td><?= $item->object->name ?></td>
            <td><?= $item->object->izm ?></td>
            <td>
              <a class="btn btn-secondary" style="cursor: pointer; color: white;" 
                href="/indocitems-form-addupdate?action=relateddoc.addrelateddoc.do&
                relateddoc[doc_id]=<?= $doc_id ?>&
                relateddoc[relateddoc_id]=<?= $item->object->id ?>&
                relateddoc[type]=5">Связать</a>
            </td>
          </tr>
        <?endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="tab-pane" id="users" role="tabpanel" aria-labelledby="users-tab">
    <table id="datatableForRelatedUsers" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>ФИО</th>
          <th>Роль</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?foreach ($users as $item) :?>
          <tr>
            <td><?= $item->object->params->f.' '.$item->object->params->i?></td>
            <td><?= $user_roles[$item->object->role] ?></td>
            <td>
              <a class="btn btn-secondary" style="cursor: pointer; color: white;" 
                href="/indocitems-form-addupdate?action=relateddoc.addrelateddoc.do&
                relateddoc[doc_id]=<?= $doc_id ?>&
                relateddoc[relateddoc_id]=<?= $item->object->id ?>&
                relateddoc[type]=6">Связать</a>
            </td>
          </tr>
        <?endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<script>
  $('#datatable').DataTable();
</script>