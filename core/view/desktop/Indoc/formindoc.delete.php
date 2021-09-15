<?php 
    
    use RedCore\Forms;
    use RedCore\Request;
    use RedCore\Indoc\Collection as Indoc;
    
    
    $html_object = "oindoc";
    
    Indoc::setObject($html_object);
    
    $lb_params = array(
        "id" => Request::vars("oindoc_id"),
    );
   
    $oindoc_item = Indoc::loadBy($lb_params);

    $form = Forms::Create()
        ->add("action", "action", "hidden", "action", $html_object. ".delete.do", 6, false)
        ->add("redirect", "redirect", "hidden", "redirect", "indocitems-list", 6, false)
        ->add("id", "id", "hidden", $html_object . "[id]", $oindoc_item->object->id)
        ->add("html", "", "html", "", "Вы действительно хотите удалить: " . $oindoc_item->object->name_doc . "?")
        ->setSubmit("Удалить", "Отмена")
        ->parse();
    
?>


<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>ДОКУМЕНТЫ<small>форма удаления</small></h2>
        
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