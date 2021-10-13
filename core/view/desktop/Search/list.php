<?php

use \RedCore\Search\Collection as Search;
use RedCore\Where;

Search::setObject("osearch");
$items = Search::getList(); 


?>

<a class="btn btn-primary" href="/searchitems-download">Выгрузить в Excel</a>

<form  method = "post">
  <div class="form-search">
  	<input type="hidden" name="action" id="action" value="osearch.searchall.do">
    <input name="osearch[search]" type="text" class="form-search">
  </div>
  <button type="submit" class="btn btn-primary">Отправить</button>
</form>



<table id="datatable" class="table table-striped table-bordered" style="width:100%">
  <thead>
    <tr> 
    <th>Тип документа</th>
			<th>Имя документа</th>
			<th>№ Регистрации</th>
			<th>Дата регистрации</th>
			<th>Резолюции</th>
			<th>Статус</th>
			<th>Файл</th>
			<th>Действие</th>
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