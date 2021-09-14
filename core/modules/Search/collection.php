<?php
/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Search;

use \RedCore\Where as Where;
use RedCore\Session;
use RedCore\Controller;
use RedCore\Core as Core;
use RedCore\Request;
use RedCore\Files;




require_once('sql.php');
require_once('object.php');

class Collection extends \RedCore\Base\Collection { 
/*
 * 
 * 
 * 
 */
    public static function export(){
        $objExcel = new \PHPExcel();
        $objExcel -> setActiveSheetIndex(0);
        
        $active_sheet = $objExcel -> getActiveSheet()->setTitle('Прайс лист');
        $active_sheet->mergeCells("A1:B1")->setCellValue('A1', 'Нужный текст')->getStyle('A1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'BB0000')
                )
            )
            );
        $active_sheet->mergeCells("A3:B3")->setCellValue('A3', 'нужный текст');
        $active_sheet->mergeCells("D1:E1")->setCellValue('D1', 'Нужный текст2');
        $active_sheet->mergeCells("D3:E3")->setCellValue('D3', 'нужный текст2');
        
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
        $objWriter -> save('php://output');
    }
    /*
     * 
     * 
     */
    public static $list = array(
        "0" => "Не выбран",
        
        "1" => "Входящие",
        "2" => "Исходящие",

    );
    /*
     * 
     * 
     */
    
    public static function getStatuslist(){
        return self::$list;
    }
    
    
    
	/**
	 * @method \RedCore\Base\Collection setObject()
	 */

	public static function setObject($obj = "osearch") {

		if("osearch" == $obj) {
			self::$object = "osearch";
			self::$sql    = Sql::$sqlSearch;
			self::$class  = "RedCore\Search\ObjectSearch";
		}

	}

	/**
	 * @method \RedCore\Base\Collection loadBy()
	 *
	 * @return \RedCore\Users\ObjectSearch ObjectTest
	 */
	public static function loadBy($params = array()) {
	    return parent::loadBy($params);
	}

	/**
	 * @method \RedCore\Base\Collection getList()
	 *
	 * @return \RedCore\Users\ObjectSearch ObjectSearch
	 */
	public static function getList($where = "") {
	    return parent::getList($where);
	}

	public static function store($params = array()) {
	    if ("osearch" == key($params)) {
	       // $title = Files::upload("otest", "file");
	        $params["osearch"]["params"]["file_title"] = Files::upload("osearch", "file");
	    }
	    parent::store($params);
		
	}
 }
	

