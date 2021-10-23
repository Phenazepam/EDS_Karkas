<?php

use RedCore\Search\Collection as Search;
use RedCore\Request;
use RedCore\Forms;
use RedCore\Search\ObjectSearch;

$html_object = "osearch";

Search::setObject($html_object);

$lb_params = array(
  "id" => Request::vars("osearch_id"),
);

$osearch_item = Search::loadBy($lb_params);

$select_params["list"] = Search::getStatuslist();

$form = Forms::Create()
  ->add("action",   "action",   "hidden", "action",   $html_object . ".store.do", 6, false)
  ->add("redirect", "redirect", "hidden", "redirect",   "search-list", 6, false)

  ->add("status_id", "Статус", "select", $html_object . "[params][status_id]", $osearch_item->object->params->status_id, 6, FALSE, $select_params)

  ->parse();
?>
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>ПОЛЬЗОВАТЕЛИ<small>форма редактирования</small></h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
              <?= $form ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>