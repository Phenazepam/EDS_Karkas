<?php 
	use RedCore\Infodocs\Collection as Infodocs;
	use RedCore\Request as Request;
	use RedCore\Forms as Forms;
	use RedCore\Session as Session;

	$html_object = "oinfodocsagents";
	
	$lb_params = array(
		"id" => Request::vars("oinfodocsagents_id"),
	);
	
	Infodocs::setObject("oinfodocsagents");
	$item = Infodocs::loadBy($lb_params);
	$item = $item->object;
	

	//var_dump(Session::get("controller_user_auth"));
	//var_dump($_SESSION);
	$form = Forms::Create()
		->add("action",   "action",   "hidden", "action",                     $html_object. ".store.do",         6, false)
		->add("redirect", "redirect", "hidden", "redirect",                   "infodocs-agents",                       6, false)
		->add("id",          "Id",       "hidden", $html_object . "[id]",        htmlspecialchars($item->id),        6, false)
		->add("name",        "Наименование",  "text",   $html_object . "[name]", htmlspecialchars($item->name), 6, true)
		->add("inn",         "ИНН",      "text",   $html_object . "[inn]", htmlspecialchars($item->inn), 6, true)
		->add("group_ka",    "Группа",  "text",   $html_object . "[group_ka]", htmlspecialchars($item->group_ka), 6, true)
		->add("material",    "Материал",      "text",   $html_object . "[material]", htmlspecialchars($item->material), 6, true)
		->add("main_worker", "Ответственный",      "text",   $html_object . "[main_worker]", htmlspecialchars($item->main_worker), 6, true)
		->add("other",       "Примечание",      "text",   $html_object . "[other]", htmlspecialchars($item->other), 6, true)
		->parse();	
?>


<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>ПОЛЬЗОВАТЕЛИ<small>форма редактирования справочника контрагентов</small></h2>
        
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

