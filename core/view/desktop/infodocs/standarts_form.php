<?php 
	use RedCore\Infodocs\Collection as Infodocs;
	use RedCore\Request as Request;
	use RedCore\Forms as Forms;
	use RedCore\Session as Session;


	$html_object = "oinfodocsstandarts";
	
	
	
	$lb_params = array(
        "id" => Request::vars("oinfodocsstandarts_id"),
    );
	
	Infodocs::setObject($html_object);
	$item = Infodocs::loadBy($lb_params);
	$item = $item->object;
	

	$form = Forms::Create()
		->add("action",   "action",   "hidden", "action",                     $html_object. ".store.do",         6, false)
		->add("redirect", "redirect", "hidden", "redirect",                   "infodocs-standarts",                       6, false)
		->add("id",          "Id",       "hidden", $html_object . "[id]",        htmlspecialchars($item->id),        6, false)
		->add("name",        "Наименование",  "text",   $html_object . "[name]", htmlspecialchars($item->name), 6, true)
		->add("izm",         "Измерение",      "text",   $html_object . "[izm]", htmlspecialchars($item->izm), 6, true)
		->add("ku",    "Коэф. умнож",  "text",   $html_object . "[ku]", htmlspecialchars($item->ku), 6, true)
		->add("bp",    "БП",      "text",   $html_object . "[bp]", htmlspecialchars($item->bp), 6, true)
		->add("fp", "ФП",      "text",   $html_object . "[fp]", htmlspecialchars($item->fp), 6, true)
		->add("rostverk",       "Ростверк",      "text",   $html_object . "[rostverk]", htmlspecialchars($item->rostverk), 6, true)
		->add("walls",       "Стены",      "text",   $html_object . "[walls]", htmlspecialchars($item->walls), 6, true)
		->add("kolon",       "Колонны",      "text",   $html_object . "[kolon]", htmlspecialchars($item->kolon), 6, true)
		->add("perekryt",       "Перекрытия",      "text",   $html_object . "[perekryt]", htmlspecialchars($item->perekryt), 6, true)
		->add("balki",       "Балки",      "text",   $html_object . "[balki]", htmlspecialchars($item->balki), 6, true)
		->add("rigel",       "Ригель",      "text",   $html_object . "[rigel]", htmlspecialchars($item->rigel), 6, true)
		->add("smallconstr",       "Малые конструкции",      "text",   $html_object . "[smallconstr]", htmlspecialchars($item->smallconstr), 6, true)
		->add("decor",       "Декор",      "text",   $html_object . "[decor]", htmlspecialchars($item->decor), 6, true)
		->add("pryamlest",       "Прямые лест. марши",      "text",   $html_object . "[pryamlest]", htmlspecialchars($item->pryamlest), 6, true)
		->add("krivlest",       "Кривые лест. марши",      "text",   $html_object . "[krivlest]", htmlspecialchars($item->krivlest), 6, true)
		->parse();	
?>


<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>НОРМАТИВНО-СПРАВОЧНАЯ ДОКУМЕНТАЦИЯ<small>редактирование справочника норм</small></h2>
        
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
