<?php

use RedCore\Indoc\Collection as Indoc;
use RedCore\Session as Session;
use RedCore\Where as Where;
use RedCore\Config as Config;

$session_year          = (int)Session::get("general_filter_year_id");
if(-1 == $session_year) Session::set("general_filter_month_id", -1);
$session_month         = (int)Session::get("general_filter_month_id");
$session_doctypes = (int) Session::get("general_filter_doc_types");
$session_doc_step = (int) Session::get("general_filter_doc_step");

$now_year_id = date('Y');

$now_month_id = date('m');

$filter_years_list = array();

$filter_years_list = array(
    -1 => 'все',
);

for($i=Config::$begin_year; $i <= (date("Y")+1); $i++) {
    if((int)$now_year_id == (int)$i)
        $now_year_id = $i-(int)Config::$begin_year+1;
        
        $filter_years_list[$i-(int)Config::$begin_year+1] = $i;
}

$filter_month_list = array(
    -1 => 'все',
);

for($i=1; $i <= 12; $i++) {
    if((int)$now_month_id == (int)$i)
        $now_month_id = $i;
        
        $filter_month_list[$i] = getRusMonth($i);
}

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

$filter_doc_step_list = array(
    "-1" => "Не выбран",
    
    "1" => "Черновик",
    "2" => "Согласование",
    "3" => "Утверждение",
    "4" => "Принятие"
   
);

?>

<div class="col-12">
    <div class="section-content content-details">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="text-center" style="font-weight: bold;"></div>
                <div class="row">    
          
            <div class="col-lg-1 text-center">
            	<div class="text-center" style="font-weight: bold;">Сегодня</div>
            	<a class="btn btn-sm btn-block btn-light" href="/indocitems-list?filter_year_id=<?=$now_year_id?>&filter_month_id=<?=$now_month_id?>"><i class="icon-calendar icons"></i> <?=date("d.m.Y")?></a>      	
            </div> 
            
            <div class="col-lg-2">
            	<div class="text-center" style="font-weight: bold;">Месяц</div>
            	<button class="btn btn-sm btn-block btn-light dropdown-toggle" type="button" id="dropdownMonthBar" data-toggle="dropdown" aria-haspopup="true" 
            		aria-expanded="false"><i class="icon-calendar icons"></i> <?=$filter_month_list[$session_month]?></button>      	
                <div class="dropdown-menu" aria-labelledby="dropdownMonthBar">
                	<? foreach ($filter_month_list as $filter_month_id => $filter_month_title): ?>
                		<a class="dropdown-item" <?=(($filter_month_id == $session_month) ? 'style="color: #ccc"' : ('href="/indocitems-list?filter_month_id=' . $filter_month_id . '"'))?>><?=$filter_month_title?></a>
                    <? endforeach; ?>
                </div>	    
            </div>
            
            <div class="col-lg-1">
            	<div class="text-center" style="font-weight: bold;">Год</div>
            	<button class="btn btn-sm btn-block btn-light dropdown-toggle" type="button" id="dropdownYearBar" data-toggle="dropdown" aria-haspopup="true" 
            		aria-expanded="false"><i class="icon-calendar icons"></i> <?=$filter_years_list[$session_year]?></button>      	
                <div class="dropdown-menu" aria-labelledby="dropdownYearBar">
                <? foreach ($filter_years_list as $filter_year_id => $filter_year_title): ?>
                	<a class="dropdown-item" <?=(($filter_year_id == $session_year) ? 'style="color: #ccc"' : ('href="/indocitems-list?filter_year_id=' . $filter_year_id . '"'))?>><?=$filter_year_title?></a>
                <? endforeach; ?>
                </div>	  
            </div>  
                    <div class="col-lg-2">
                        <div class="text-center" style="font-weight: bold;">Тип документа</div>
                        <button class="btn btn-sm btn-block btn-light dropdown-toggle" type="button" id="dropdownCategoryBar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-calendar icons"></i> <?= $filter_doc_types_list[$session_doctypes] ?></button>
                        <div class="dropdown-menu" aria-labelledby="dropdownTypesBar">
                            <? foreach ($filter_doc_types_list as $filter_doc_types_id => $filter_doc_types_title) : ?>
                                <a class="dropdown-item" <?= (($filter_doc_types_id == $session_doctypes) ? 'style="color: #ccc"' : ('href="/indocitems-list?filter_doc_types_id=' . $filter_doc_types_id . '"')) ?>><?= $filter_doc_types_title ?></a>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="text-center" style="font-weight: bold;">Статус</div>
                        <button class="btn btn-sm btn-block btn-light dropdown-toggle" type="button" id="dropdownCategoryBar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-calendar icons"></i> <?= $filter_doc_step_list[$session_doc_step] ?></button>
                        <div class="dropdown-menu" aria-labelledby="dropdownStatusBar">
                            <? foreach ($filter_doc_step_list as $filter_doc_step_id => $filter_doc_step_title) : ?>
                                <a class="dropdown-item" <?= (($filter_doc_step_id == $session_doc_step) ? 'style="color: #ccc"' : ('href="/indocitems-list?filter_doc_step_id=' . $filter_doc_step_id . '"')) ?>><?= $filter_doc_step_title ?></a>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>