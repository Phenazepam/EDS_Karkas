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
use RedCore\Infodocs\Collection as Infodoc;
use PHPExcel_IOFactory;

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

	static $uploadDictionaryConfig = array(
		'agents' => array(
			'object' => 'oinfodocsagents',
			'class' => 'RedCore\Infodocs\Collection',
			'fields' =>	array(
				"name",
				"inn",
				"group_ka",
				"material",
				"main_worker",
				"other",
			)
		)
	);



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
	       $i++;	       
	   };
 
	   $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
	   $objWriter -> save('php://output');
	  }

	public static function UploadDictionaryFile()
	{
		$response = array(
			"responseCode" => '',
			"uploadedCount" => '',
			"errors" => array(),
		);
		$dictionary = $_POST["dictionary"];
		$object = self::$uploadDictionaryConfig[$dictionary]["object"];
		$fields = self::$uploadDictionaryConfig[$dictionary]["fields"];
		$class = self::$uploadDictionaryConfig[$dictionary]["class"];

		$count = 0;
		if (isset($_FILES["dataFile"])) {
			$file = $_FILES["dataFile"];
			$data = self::readExcel($file["tmp_name"]);
			foreach ($data as $key => $value) {
				foreach ($value as $k => $v)
				$params[$object][$fields[$k]] = $v;

				$class::setObject($object);	
				self::store($params);
				// var_dump(self::$object);
				$count++;
			}
			if ($count > 0) {
				$response["responseCode"] = 'success';
				$response["uploadedCount"] = $count;
			} else {
				$response["responseCode"] = 'error';
				$response["uploadedCount"] = $count;
			}
			// var_dump($response);
			echo json_encode($response);
		} else {
			$response = array(
				"responseCode" => 'error',
				"uploadedCount" => '0',
				"errors" => 'File is not uploaded'
			);

			echo json_encode($response);
		}

		exit();
	}

	public static function readExcel($filename)
	{	
		$excel = PHPExcel_IOFactory::load($filename);
		foreach ($excel->getWorksheetIterator() as $worksheet) {
			$lists[] = $worksheet->toArray();
		}
		$header = NULL;
		$data = array();
		$keys = array();
		foreach ($lists as $list) {
			foreach ($list as $row) {
				$values=array();
				if (empty($keys)) {
					$i=0;
					foreach ($row as $col) {
						// $keys[] = $col;
						$keys[] = $i++;
					}	
				} else {
					foreach ($row as $col) {
						$values[] = $col;
					}	
					// var_dump($keys);
					// echo PHP_EOL;
					// var_dump($values);
					// echo '===================================================='.PHP_EOL;
					$tmp = array_combine($keys, $values);
					// var_dump($tmp);
					// $data[] = array_combine($header, $row);
					$data[] = $tmp;
				}
			}
		}
		return $data;
	}
	  
 }