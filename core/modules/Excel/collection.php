<?php
/**
 * @copyright 2021
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore\Excel;

use \RedCore\Where as Where;
use RedCore\Session;
use RedCore\Controller;
use RedCore\Core as Core;
use RedCore\Request;
use RedCore\Files;
use RedCore\Indoc\Collection as Indoc;

class Collection extends \RedCore\Base\Collection { 

	/**
	 * @method \RedCore\Base\Collection setObject()
	 */

	public static function setObject($obj = "oexcel") {

		if("oexcel" == $obj) {
			self::$object = "oexcel";
			self::$class  = "RedCore\Search\ObjectExcel";
		}

	}

	public static function export($items, $header_array, $report_name = 'Выгрузка Документы') {
	    // $items = Indoc::getList();
	    // $status_list = Indoc::getStatuslist();
	    // Indoc::setObject('odoctypes');
	    // $DocTypes_list = Indoc::getList();
		// $cnt_headers = count($header_array);
		// $cnt_items= count($items);
	    
	    $objExcel = new \PHPExcel();
	    $objExcel -> setActiveSheetIndex(0);
	    
	    $active_sheet = $objExcel -> getActiveSheet()->setTitle('Прайс лист');
	    $active_sheet->setCellValue('A1', $report_name);

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
			),
			'borders'=>array(
	            'allborders' => array(
	                'style' => \PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('rgb' => '000000')
	            )
	        )
	    );
	    
	    // $active_sheet
	    //    ->getStyle("A4:E".$cnt_headers)
	    //    ->applyFromArray($bg);
	    
	    // $active_sheet
	    //    ->getStyle("A4:E".$cnt_items)
	    //    ->applyFromArray($border);
	    
	    
	    $row_start = 4;
	    $i = 0;
	    
	    $row_next = $row_start + $i;
	    $column_next = 0;
	    
	    foreach ($header_array as $vale) {	        
	        $active_sheet
	           ->setCellValueByColumnAndRow($column_next, $row_next, $vale)
	           ->getColumnDimensionByColumn($column_next)
	           ->setWidth(20);
			$active_sheet
				->getStyleByColumnAndRow($column_next, $row_next)
				->applyFromArray($bg);
		
	        $column_next++; 
	    }
	    
	    $i++;

	    foreach ($items as $val) {	       
	       $row_next = $row_start + $i;
		   $column_next = 0;
		   foreach ($val as $tmp) {
				$active_sheet
					->setCellValueByColumnAndRow($column_next, $row_next, $tmp);
				$active_sheet
					->getStyleByColumnAndRow($column_next, $row_next)
					->applyFromArray($border);
				$column_next++;
		   }
	      	    	       
	    //    $active_sheet
	    //        ->setCellValueByColumnAndRow(0, $row_next, $DocTypes_list[$val->params->doctypes]->object->title);
	       
	    //    $active_sheet
    	//        ->setCellValueByColumnAndRow(1, $row_next, $val->name_doc)
    	//        ->getColumnDimension('B')
    	//        ->setWidth(20);
	       
	    //    $active_sheet
    	//        ->setCellValueByColumnAndRow(2, $row_next, $val->reg_number)
    	//        ->getColumnDimension('C')
    	//        ->setWidth(20);
	       
	    //    $active_sheet
    	//        ->setCellValueByColumnAndRow(3, $row_next, $val->reg_date)
    	//        ->getColumnDimension('D')
    	//        ->setWidth(20);
	       
	      
	    //    $active_sheet
    	//        ->setCellValueByColumnAndRow(4, $row_next, $status_list[$val->status])
    	//        ->getColumnDimension('E')
    	//        ->setWidth(20);

	       $i++;	       
	   };
 
	   $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
	   $objWriter -> save('php://output');
	  }
	  
 }