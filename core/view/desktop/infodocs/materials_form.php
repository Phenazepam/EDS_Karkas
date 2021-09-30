<?php 
	use RedCore\Infodocs\Collection as Infodocs;
	use RedCore\Request as Request;
	use RedCore\Forms as Forms;
	use RedCore\Session as Session;


	$html_object = "oinfodocsmaterials";
	
	
	
	$lb_params = array(
        "id" => Request::vars("oinfodocsmaterials_id"),
    );
	
	Infodocs::setObject($html_object);
	$item = Infodocs::loadBy($lb_params);
	$item = $item->object;
	

	$form = Forms::Create()
		->add("action",   "action",   "hidden", "action",                     $html_object. ".store.do",         6, false)
		->add("redirect", "redirect", "hidden", "redirect",                   "infodocs-materials",                       6, false)
		->add("id",          "Id",       "hidden", $html_object . "[id]",        htmlspecialchars($item->id),        6, false)
		->add("su",        "Счет учета",  "text",   $html_object . "[su]", htmlspecialchars($item->su), 6, true)
		->add("code",         "Код",      "text",   $html_object . "[code]", htmlspecialchars($item->code), 6, true)
		->add("gruppa",    "Группа",  "text",   $html_object . "[gruppa]", htmlspecialchars($item->gruppa), 6, true)
		->add("material",    "Материал",      "text",   $html_object . "[material]", htmlspecialchars($item->material), 6, true)
		->add("izm", "Измерение",      "text",   $html_object . "[izm]", htmlspecialchars($item->izm), 6, true)
		->parse();	
?>


<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>редактирование справочника материалов</small></h2>
        
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

