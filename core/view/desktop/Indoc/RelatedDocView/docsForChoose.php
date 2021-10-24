<?php
use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where;
use RedCore\Users\Collection as Users;
use RedCore\Search\Collection as Search;
use RedCore\Request as Request;

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

?>
<link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link href="/template/general/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="/template/general/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script src="/template/general/vendors/jquery/dist/jquery.min.js"></script>
<script src="/template/general/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<table id="datatableForRelated" class="table table-striped table-bordered" style="width:100%">
  <thead>
    <tr>
      <th>Тип документа</th>
      <th>Имя документа</th>
      <th>id</th>
      <th>№ Регистрации</th>
      <th>Дата регистрации</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?
    foreach ($items as $item) :
     
    ?>
        <tr>
          <td><?= $DocTypes_list[$item->object->params->doctypes]->object->title ?></td>
          <td><?= $item->object->name_doc ?></td>
          <td><?= $item->object->id ?></td>
          <td><?= $item->object->reg_number ?></td>
          <td><?= $item->object->reg_date ?></td>
          <td>
              <a class="btn btn-secondary" style="cursor: pointer; color: white;" 
                href="/indocitems-form-addupdate?action=relateddoc.addrelateddoc.do&relateddoc[doc_id]=<?=$doc_id?>&relateddoc[relateddoc_id]=<?=$item->object->id?>">Связать</a>
          </td>
        </tr>
    <?

    endforeach;
    ?>
  </tbody>
  
  <script>
      $('#datatable').DataTable();
  </script>
</table>