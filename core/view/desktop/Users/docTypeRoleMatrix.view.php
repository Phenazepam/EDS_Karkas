<?php

use \RedCore\Users\Collection as Users;
use \RedCore\Indoc\Collection as DocType;
use \RedCore\Where as Where;

DocType::setObject("odoctypes");

$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();

$doc_types = DocType::getList($where);

$doc_steps = DocType::getRouteStatuses();

$user_roles = Users::$roles;

Users::setObject("accessmatrix");
$accessList = Users::getList($where); 

// var_dump($accessList);
foreach($accessList as $item){
  $accessResult[$item->object->doctype] = json_decode($item->object->roles->access);
}

Users::setObject("doctyperolematrix");
$matrix = Users::getList($where); 

$colorsList = array(
  '1' => 'pink',
  '2' => 'lightblue',
  '3' => 'lightgreen',
  '4' => 'yellow'
);

// var_dump($matrix);
foreach($matrix as $doctype_id => $item){
  foreach((array)json_decode($item->object->steps->steps) as $step_id => $steps){
    foreach($steps as $q => $role_id){
      $matrix_ready[$item->object->doctype][$role_id][] = str_replace('"','',$step_id); 
    }
  }
}


foreach($matrix_ready as $k => $doctypes){
  foreach($doctypes as $h => $roles){
    foreach($roles as $q => $step_id){
      $count[$k][$step_id]++;
        $matrix_title[$k][$h]["liter"] .= substr($doc_steps[str_replace('"','',$step_id)],0,2).$count[$k][$step_id].' '; 
        $matrix_title[$k][$h]["color"] = $colorsList[$step_id];
    }
  }
}
// var_dump($count);
// var_dump($matrix_title);

Users::GetNextStep('22', '1', '4');
?>
<script src="/core/view/desktop/Users/js/popupForChoosingStep.js"></script>
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Матрица доступа</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="accessmatrix.store.do">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <div class="card-box table-responsive">

            
              <!-- <a class="btn btn-primary" href="/users-form">Добавить <i class="fa fa-plus"></i></a> -->
              <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th></th>
                      <?php
                      foreach ($user_roles as $user_id => $user_role) :

                      ?>
                    <th style="writing-mode: tb-rl"><?= $user_role ?></th>

                  <?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $isFirstLine = true;
                  foreach ($doc_types as $doctype_id => $doc_type) :
                  ?>
                    <tr>
                      <td><?= $doc_type->object->title ?></td>
                      <?php
                      foreach ($user_roles as $user_id => $user_role) :
                      ?>
                        <td class="active-td" onclick="popupForChoosingSteps(<?=$doctype_id?>, <?=$user_id?>)" 
                          style="font-weight:bold;background-color: <?=$matrix_title[$doctype_id][$user_id]['color']?>;">
                          <?=$matrix_title[$doctype_id][$user_id]['liter']?>
                        </td>
                      <?php
                      endforeach;
                      ?>
                    </tr>
                  <?php
                  endforeach;
                  ?>
                </tbody>
              </table>
              
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .active-td{
    cursor: pointer;
  }
  .active-td:hover{
    background-color: royalblue;
    opacity: .8;
  }
</style>
