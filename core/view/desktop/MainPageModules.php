<?php
/*
 Массив ролей
	"0" => "Не выбрана",		
    "1" => "Система",
	"2" => "Администратор",
    "3" => "Гость",
    "4" => "Специалист ИТР",
    "5" => "Нач. отдела ИТР",
    "6" => "Сотрудник юр. отдела",
	"7" => "Сотрудник отдела кадров",
	"8" => "Специалист ПТО",
	"9" => "Нач. отдела ПТО",
	"10" => "Специалист ПЭО",
	"11" => "Нач. отдела ПЭО",
	"12" => "Нарыжный Е.В.",
	"13" => "Главный механик",
	"14" => "Специалист ОМТС",
	"15" => "Кущенко Н.В.",
	"16" => "Икономиди С.Ю.",
	"17" => "Специалист бухгалтерии",
	"18" => "Нач. отдела бухгалтерии",
	"19" => "Руководитель",
*/
return
array(
    /*'document' => array(
        'name' => 'Документы',
        'tag' => 'docs',
        'userAccess' => array()
    ), */
    'admin' => array(
        'name' => 'Администрирование',
        'tag' => 'admin',
        'userAccess' => array('1', '2', '19')
    ),
    'dictionary' => array(
        'name' => 'Справочники',
        'tag' => 'dictionary',
        'userAccess' => array('1', '2', '19')
    ),
    'infodoc' => array(
        'name' => 'Нормативно-справочная документация',
        'tag' => 'infodoc',
        'userAccess' => array()
    ),
);

?>