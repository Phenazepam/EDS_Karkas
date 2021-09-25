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
use RedCore\Indoc\Collection as Indoc;



require_once('sql.php');
require_once('object.php');

class Collection extends \RedCore\Base\Collection { 

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
			self::$sql    = Sql::$sqlIndoc;
			self::$class  = "RedCore\Search\ObjectSearch";
		}

	}

	/**
	 * @method \RedCore\Base\Collection loadBy()
	 *
	 * @return ObjectSearch
	 */
	public static function loadBy($params = array()) {
	    return parent::loadBy($params);
	}

	/**
	 * @method \RedCore\Base\Collection getList()
	 *
	 * @return \RedCore\Users\ObjectUser
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
	/*
	 * 
	 * 
	 */
	
	public static function export($header_array, $items){
	    $items = Indoc::getList();
	    $status_list = Indoc::getStatuslist();
	    Indoc::setObject('odoctypes');
	    $DocTypes_list = Indoc::getList();
	    
	    $objExcel = new \PHPExcel();
	    $objExcel -> setActiveSheetIndex(0);
	    
	    $active_sheet = $objExcel -> getActiveSheet()->setTitle('Прайс лист');
	    $active_sheet->setCellValue('A1', 'ДОКУМЕНТЫ');
	  	  	    
	    foreach ($header_array as $val) {
	        $row_next = $row_start + $i;
	        $active_sheet->setCellValueByColumnAndRow(0, $row_next, $val[]);
	    }
	    //var_dump($header_array);
	   
	    $row_start = 4;
	    $i = 0;
	    
	   foreach ($items as $val) {	       
	       $row_next = $row_start + $i;
	      	       
	       $active_sheet
	           ->setCellValueByColumnAndRow(0, $row_next, $DocTypes_list[$val->object->params->doctypes]->object->title)
	           ->getColumnDimensionByColumn('A')
	           ->setAutoSize(true);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(1, $row_next, $val->object->name_doc)
    	       ->getColumnDimensionByColumn('B')
    	       ->setAutoSize(true);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(2, $row_next, $val->object->reg_number)
    	       ->getColumnDimensionByColumn('C')
    	       ->setAutoSize(true);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(3, $row_next, $val->object->reg_date)
    	       ->getColumnDimensionByColumn('D')
    	       ->setAutoSize(true);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(4, $row_next, $val->object->resolution)
    	       ->getColumnDimensionByColumn('E')
    	       ->setAutoSize(true);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(5, $row_next, $status_list[$val->object->params->status_id])
    	       ->getColumnDimensionByColumn('F')
    	       ->setAutoSize(true);

	       $i++;	       
	   };
	   
	   $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
	   $objWriter -> save('php://output');
	  }

 }
	

