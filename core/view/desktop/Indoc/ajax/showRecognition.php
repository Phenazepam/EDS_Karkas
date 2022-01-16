<?php
use RedCore\Users\Collection as Users;
use RedCore\Indoc\Collection as Indoc;
use RedCore\Where;


$rec_id = $_REQUEST['rec_id'];

Indoc::setObject("orecognition");
$data = Indoc::loadBy(array('id' => $rec_id));
$text = $data->object->rec_text;

$text = mb_substr($text, 1, -1);
$text = mb_substr($text, 0, -1);
$text = $text . "}";

$text_arr = json_decode($text);
$result = array();
$text_symbol = "#text";

//print_r($text_arr);

foreach($text_arr->document->page->block as $block) {
	$char_arr = array();
	
	//print_r($block);
	
	foreach($block->text->par->line->formatting->charParams as $char) {
		//echo $char->$text_symbol . "<br>";
		if(empty($char->$text_symbol)) {
			$char_arr[] = " ";
		}
		else {
			$char_arr[] = $char->$text_symbol;
		}
	}
	
	foreach($block->text->par->line->charParams as $char) {
		//echo $char->$text_symbol . "<br>";
		if(empty($char->$text_symbol)) {
			$char_arr[] = " ";
		}
		else {
			$char_arr[] = $char->$text_symbol;
		}
	}
	
	$char_string = implode('', $char_arr);
	
	if(!empty($char_string)) {
		$result["text"][] = $char_string;
	}
	
	foreach($block->row as $row_item) {
		//print_r($row_item);
		$row = array();
		
		foreach($row_item->cell as $cell_item) {
			//print_r($cell_item);
			$char_table_arr = array();
			
			foreach($cell_item->text->par->line as $line_item) {
				//print_r($line_item); echo "=========================";
				
				foreach($line_item->formatting->charParams as $char) {
					if(empty($char->$text_symbol)) {
						$char_table_arr[] = " ";
					}
					else {
						$char_table_arr[] = $char->$text_symbol;
					}
				}
				
				foreach($line_item->charParams as $char) {
					if(empty($char->$text_symbol)) {
						$char_table_arr[] = " ";
					}
					else {
						$char_table_arr[] = $char->$text_symbol;
					}
				}
				
				$char_table_arr[] = " ";
			}
			
			$char_table_string_cell = implode('', $char_table_arr);
			//echo $char_table_string;
			
			if(!empty($char_table_string_cell)) {
				$row[] = $char_table_string_cell;
			}
		}
		
		$result["rows"][]  = $row;
		
		/*$row_string = implode(' | ', $row);
		
		if(!empty($row_string)) {
			$result["rows"][]  = $row_string;
		}*/
	}
	
	
	
}


//$text = "result";
//print_r($result);

?>
<form action="/indocitems-form-view?action=oindoc.ajaxMoveRoute.do" 
    method="post" id="popup" name="oindoc"> 
    <div class="popup_body" style="text-align: left;">
		<h2>Текст</h2>
		<?
			foreach($result["text"] as $tblock){
		?>

				<p><?=$tblock?></p>
		<?
			}
		
		?>
	
		<h2>Таблица</h2>
		<div style="width: auto; overflow: auto">
			<table>
			<?
				foreach($result["rows"] as $row){
			?>
					<tr>
			<?
					foreach($row as $cell) {
			?>
					<td style="border-width: 1px;"><?=$cell?></td>
			<?
					}
			?>
					</tr>
			<?
				}
			
			?>
			</table>
		</div>
    </div>
</form>