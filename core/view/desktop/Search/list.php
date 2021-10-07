<?php

use \RedCore\Search\Collection as Search;
use RedCore\Where;

Search::setObject("osearch");

$items = Search::getList();

//$searcf = Search::searchall();

//var_dump($searcf);
?>

<a class="btn btn-primary" href="/searchitems-download">Выгрузить в Excel</a>

<a class="btn btn-primary" href="/searchitems-form">Поиск</a>

<form name="form" action="/searchitems-list?action=osearch.searchall.do" method="post">
      
      <input type="text" name="doc_name" > 
      <input type="submit"  value="Искать" >  
         
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