<?php
use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where as Where;
use RedCore\Config as Config;

$session_doctypes = (int) Session::get("general_filter_doc_types");

$filter_doc_types_list = array(
    "-1" => "Не выбран",

    "1" => "Проект",
    "2" => "Сметы",
    "3" => "Ведомость договорной цены",
    "4" => "Лимитно-заборные карты",
    "5" => "График производства работ",
    "6" => "Журнал расценок",
    "7" => "Виды работ",
    "8" => "Стоимость материалов",
    "9" => "Набор работ ПЛАН",
    "10" => "Набор работ ФАКТ",
    "11" => "Универсальный передаточный документ",
    "12" => "Товарная накладная",
    "13" => "Счет-фактура",
    "14" => "Акты сверок",
    "15" => "Акт выполненых работ",
    "16" => "Счет-фактура(услуги)",
    "17" => "Реестр логистики",
    "18" => "КС-2",
    "19" => "КС-3",
    "20" => "М-29",
    "21" => "Досписание",
    "22" => "Акт списания",
    "23" => "Протокол заработной платы",
    "24" => "Счет на оплату"
);

?>

<div class="col-12">
	<div class="section-content content-details">
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="text-center" style="font-weight: bold;"></div>
				<div class="row">
					<div class="col-lg-3">
						<div class="text-center" style="font-weight: bold;">Тип документа</div>
						<button class="btn btn-sm btn-block btn-light dropdown-toggle"
							type="button" id="dropdownCategoryBar" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<i class="icon-calendar icons"></i> <?=$filter_doc_types_list[$session_doctypes]?></button>
						<div class="dropdown-menu" aria-labelledby="dropdownCategoryBar">
                	<? foreach ($filter_doc_types_list as $filter_doc_types_id => $filter_doc_types_title): ?>
                		<a class="dropdown-item"
								<?=(($filter_doc_types_id == $session_doctypes) ? 'style="color: #ccc"' : ('href="/indocitems-list?filter_doc_types_id=' . $filter_doc_types_id . '"'))?>><?=$filter_doc_types_title?></a>
                    <? endforeach; ?>
                </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>