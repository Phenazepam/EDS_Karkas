<?php 
	use RedCore\Infodocs\Collection as Infodocs;
	use RedCore\Request as Request;
	use RedCore\Forms as Forms;
	use RedCore\Session as Session;


	$html_object = "oinfodocsworks";
	
	
	
	$lb_params = array(
        "id" => Request::vars("oinfodocsworks_id"),
    );
	
	Infodocs::setObject($html_object);
	$item = Infodocs::loadBy($lb_params);
	$item = $item->object;
	

	$form = Forms::Create()
		->add("action",   "action",   "hidden", "action",                     $html_object. ".store.do",         6, false)
		->add("redirect", "redirect", "hidden", "redirect",                   "infodocs-works",                       6, false)
		->add("id",          "Id",       "hidden", $html_object . "[id]",        htmlspecialchars($item->id),        6, false)
		->add("gruppa",        "Группа",  "text",   $html_object . "[gruppa]", htmlspecialchars($item->gruppa), 6, true)
		->add("name",         "Наименование",      "text",   $html_object . "[name]", htmlspecialchars($item->name), 6, true)
		->add("izm",    "Группа",  "text",   $html_object . "[izm]", htmlspecialchars($item->izm), 6, true)
		->add("krd",    "Материал",      "text",   $html_object . "[krd]", htmlspecialchars($item->krd), 6, true)
		->add("rnd", "Ответственный",      "text",   $html_object . "[rnd]", htmlspecialchars($item->rnd), 6, true)
		->add("vldvstk",       "Примечание",      "text",   $html_object . "[vldvstk]", htmlspecialchars($item->vldvstk), 6, true)
		->add("obj1", "Ответственный",      "text",   $html_object . "[obj1]", htmlspecialchars($item->obj1), 6, true)
		->add("obj2", "Ответственный",      "text",   $html_object . "[obj2]", htmlspecialchars($item->obj2), 6, true)
		->add("obj3", "Ответственный",      "text",   $html_object . "[obj3]", htmlspecialchars($item->obj3), 6, true)
		->add("obj4", "Ответственный",      "text",   $html_object . "[obj4]", htmlspecialchars($item->obj4), 6, true)		
		->parse();	
?>


<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>редактирование справочника корреспондентов/контрагентов</small></h2>
        
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

