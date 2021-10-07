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

    public static $list = array(

    );

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
	    
	    parent::store($params);
		
	}
	/*
	 * 
	 * 
	 */
	public static function searchall($params = array()) {	    
	    $documents = Indoc::getList();
	    
	    if (empty($_POST[$params]))
	    {
        echo "Введите запрос";   
	    } else{
	           
	        $search = $_POST[$params];
	        
	            $sql = "SELECT 'doctypes', 'name_doc', 'reg_number', 'reg_date' FORM eds_karkas__document WHERE `doctypes` LIKE '%$search%' OR `name_doc` LIKE '%$search%' OR `reg_number` LIKE '%$search%' OR `reg_date` LIKE '%$search%'";

	            $result = mysqli_query($sql);

	            while ($row = mysqli_fetch_array($result)) {
	                $doctype = $row['doctype'];
	                $name_doc = $row['name_doc'];
	                $reg_number = $row['reg_number'];
	                $reg_date = $row['reg_date'];
	          
	                echo  "<a>".$doctype  ." ". $name_doc ." ". $reg_number ." ". $reg_date ."</a>";
	            }
	        }
	
	}

	/*
	 * 
	 * 
	 */
	
	public static function export($items) {
	    $items = Indoc::getList();
	    $status_list = Indoc::getStatuslist();
	    Indoc::setObject('odoctypes');
	    $DocTypes_list = Indoc::getList();
	    
	    $header_array = array('Тип документа','Имя документа','№ Регистрации','Дата регистрации','Статус');
	    
	    $objExcel = new \PHPExcel();
	    $objExcel -> setActiveSheetIndex(0);
	    
	    $active_sheet = $objExcel -> getActiveSheet()->setTitle('Прайс лист');
	    $active_sheet->setCellValue('A1', 'ДОКУМЕНТЫ');

	    $border = array(
	        'borders'=>array(
	            'allborders' => array(
	                'style' => \PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => '000000')
	            )
	        )
	    );
	    
	    $bg = array(
	        'fill' => array(
	            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'FFD700')
	        )
	    );
	    
	    $active_sheet
	       ->getStyle("A4:E4")
	       ->applyFromArray($bg);
	    
	    $active_sheet
	       ->getStyle("A4:E8")
	       ->applyFromArray($border);
	    
	    
	    $row_start = 4;
	    $i = 0;
	    
	    $row_next = $row_start + $i;
	    $column_next = 0;
	    
	    foreach ($header_array as $vale) {	        
	        $active_sheet
	           ->setCellValueByColumnAndRow($column_next, $row_next, $vale)
	           ->getColumnDimension('A')
	           ->setWidth(30);
	        
	        $column_next++; 
	    }
	    
	    $i++;

	    foreach ($items as $val) {	       
	       $row_next = $row_start + $i;
	      	    	       
	       $active_sheet
	           ->setCellValueByColumnAndRow(0, $row_next, $DocTypes_list[$val->object->params->doctypes]->object->title);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(1, $row_next, $val->object->name_doc)
    	       ->getColumnDimension('B')
    	       ->setWidth(20);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(2, $row_next, $val->object->reg_number)
    	       ->getColumnDimension('C')
    	       ->setWidth(20);
	       
	       $active_sheet
    	       ->setCellValueByColumnAndRow(3, $row_next, $val->object->reg_date)
    	       ->getColumnDimension('D')
    	       ->setWidth(20);
	       
	      
	       $active_sheet
    	       ->setCellValueByColumnAndRow(4, $row_next, $status_list[$val->object->params->status_id])
    	       ->getColumnDimension('E')
    	       ->setWidth(20);

	       $i++;	       
	   };
 
	   $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
	   //$objWriter -> save('php://output');
	  }
	  
 }
	

