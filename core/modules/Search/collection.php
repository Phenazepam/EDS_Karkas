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
        
    Indoc::setObject("oindoc");
	    $where = Where::Cond()
	    ->add("_deleted", "=", "0")
	    ->add("and")
	    ->add("doctype" , "=", "")
	    ->add("and")
	    ->add("reg_number" , "=", "")
	    ->add("and")
	    ->add("name_doc" , "=", "")
	    ->parse();
	       
	    $search_list = Indoc::getList($where); 
	    
	    foreach ($search_list as $item) {
	        
	        $search_res[$item->object->id]  = true;
	    }
	    
	    return $search_res;
	    
	    if(!empty($_POST["search"])) {
	        $where = "";
	        if ($_POST["doc_name"]) $where = addWhere($where, "`name_doc` = '".htmlspecialchars($_POST["doc_name"]))."'";
	        if ($_POST["reg_number"]) $where = addWhere($where, "`reg_number` = '".htmlspecialchars($_POST["reg_number"]))."'";
	        
	        if ($where) $test_list .= " WHERE $where";
	        echo $test_list;
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

	    $row_start = 4;
	    $i = 0;
	    
	    $row_next = $row_start + $i;
	    $column_next = 0;
	    //print_r($header_array);
	    foreach ($header_array as $vale) {	        
	       
	       // echo $vale;
	        $active_sheet
	           ->setCellValueByColumnAndRow($column_next, $row_next, $vale);
	        $column_next++;
	    
	    }
	    $i++;
	   // var_dump($header_array);
	   
	    
	    // $res = array_merge($header_array, $items);
	    //var_dump($res);
  
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
	       
	      /* $active_sheet
    	       ->setCellValueByColumnAndRow(4, $row_next, $val->object->resolution)
    	       ->getColumnDimensionByColumn('E')
    	       ->setAutoSize(true);*/
	      
	       $active_sheet
    	       ->setCellValueByColumnAndRow(4, $row_next, $status_list[$val->object->params->status_id])
    	       ->getColumnDimensionByColumn('E')
    	       ->setAutoSize(true);

	       $i++;	       
	   };
	  
	  //print_r($items);
	 // print_r($header_array);
	  
	   
	   
	   $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
	   $objWriter -> save('php://output');
	  }
	  
 }
	

