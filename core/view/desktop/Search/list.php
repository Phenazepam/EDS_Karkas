<?php

use \RedCore\Search\Collection as Search;
use RedCore\Where;

Search::setObject("osearch");

$items = Search::getList();

$filterlist = Search::getStatuslist();

?>

<a class="btn btn-primary" href="/searchitems-download">Выгрузить в Excel</a>

<div class="btn-group btn-group-sm">
            	<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Выбор таблицы для поиска
            	</button>
        	<div class="dropdown-menu">
            	<a class="dropdown-item" href="/searchitems-form_document">Document</a>
            <div class="dropdown-divider"></div>
            	<a class="dropdown-item" href="/">...</a>
            <div class="dropdown-divider"></div>
            	<a class="dropdown-item" href="/">...</a>
            </div>
            	</div>

<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Фильтр.
  </a>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    <hr>
    <h2>Фильтр</h2>
    <form action="/searchitems-form" name="filter" method="POST">

      <div class="row">
        <div class="col">
          <p>Тип док.</p>
          <div class="dropdown bootstrap-select form-control">
            <select name="selecttype_id" id="filter" class="form-control selectpicker" data-live-search="true" tabindex="-98">
              <option> <?= $filterlist[$items->object->params->status_id] ?> </option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <button type="submit" class="btn btn-primary">Применить фильтр </button>
        </div>
        <div class="col">
          <a href="/searchitems-list" class="btn btn-primary">Сбросить фильтр</a>
        </div>
      </div>
      <hr>

    </form>
  </div>
</div>

<form name="form" action="osearch.searchall.do" method="post">
  <table>
    <tr>
      <td>Поиск:</td>
      <td><input type="text" name="doc_name" /> </td>
    </tr>
	 <tr>
      <td>
        <input type="submit" name="search" value="Искать" />
      </td>
    </tr>
  </table>
</form>

<table id="datatable" class="table table-striped table-bordered" style="width:100%">
  <thead>

    <tr>
    
    </tr>
  </thead>
  
  <tbody>


    <?
    foreach ($items as $item) :


    ?>

      <tr>
      </tr>



    <?
    endforeach;

    ?>

  </tbody>
</table>