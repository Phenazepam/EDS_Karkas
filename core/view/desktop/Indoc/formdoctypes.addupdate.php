<?php
use RedCore\Forms;
use RedCore\Request;
use RedCore\Indoc\Collection as Indoc;

$html_object = "odoctypes";

Indoc::setObject($html_object);

$lb_params = array(
    "id" => Request::vars("odoctypes_id")
);

$odoctypes_item = Indoc::loadBy($lb_params);

$form = Forms::Create()->add("action", "action", "hidden", "action", $html_object . ".store.do", 6, false)
    ->add("redirect", "redirect", "hidden", "redirect", "doctypes-list", 6, false)
    ->add("id", "id", "hidden", $html_object . "[id]", $odoctypes_item->object->id)
    ->
add("title", "Тип документов", "text", $html_object . "[title]", $odoctypes_item->object->title)
    ->parse();

?>


<div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
				<h2>
					ТИП ДОКУМЕНТОВ<small>форма редактирования</small>
				</h2>

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