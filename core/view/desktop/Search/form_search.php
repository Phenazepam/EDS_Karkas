<?php
use RedCore\Forms;
use RedCore\Request;
use RedCore\Where;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Users\Collection as Users;
use RedCore\Search\Collection as Search;

$html_object = "osearch";

Search::setObject($html_object);

$lb_params = array(
  "" => Request::vars("")  
);

$osearch_item = Search::loadBy($lb_params);

$form = Forms::Create()
    ->add("action", "action", "hidden", "action", $html_object . "osearch.searchall.do", 6, false)
    ->add("redirect", "redirect", "hidden", "redirect", "searchitems-list", 6, false)
    
    ->add("id", "id", "hidden", $html_object . "[id]", "")
    ->add("search", "", "text", $html_object . "", '' )
    ->setSubmit("Искать", "Отмена")
    
    ->parse();

?>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Поиск<small></small></h2>
        
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
          <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
                <?=$form?>
       		</div>
	  	  </div>
  		</div>
	  </div>
    </div>
  </div>
</div>