<?php

use \RedCore\Users\Collection as Users;
use \RedCore\DocTypes\Collection as DocType;
use \RedCore\Where as Where;

DocType::setObject("odoctypes");

$where = Where::Cond()
  ->add("_deleted", "=", "0")
  ->parse();

$doc_types = DocType::getList($where);

$user_roles = Users::$roles;

Users::setObject("accessmatrix");
$accessList = Users::getList($where); 

// var_dump($accessList);
foreach($accessList as $item){
  $accessResult[$item->object->doctype] = json_decode($item->object->roles->access);
}

Users::GetDocTypesByUser(array('15', '3'));

?>

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
            <div class="card-box table-responsive">

              <form method="post" enctype="multipart/form-data">
              <input type="hidden" name="action" id="action" value="accessmatrix.store.do">
              <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            
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
                        $checked = '';
                        if (in_array($user_id, $accessResult[$doctype_id])) {
                          $checked = 'checked';
                        }
                      ?>
                        <td>
                          <input type="checkbox" name="accessmatrix[<?=$doctype_id?>_<?=$user_id?>]" 
                            id="<?=$doctype_id?>_<?=$user_id?>" <?=$checked?>>
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