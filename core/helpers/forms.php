<?php

namespace RedCore;

class Forms {
	
	private $submit   = "Сохранить";
	private $cancel   = "Отмена";
	private $fields   = array();
	private $rs       = '';
	private $formdata = '';
	private $disabled   = '';
	
	public static function Create() {
		$obj           = new Forms;
		$obj->fields   = array();
		$obj->rs       = '';
		$obj->formdata = '';
		return $obj;
	}
	
	public function addFormData($add = "") {
		$this->formdata = $add;
		
		return $this;
	}
	
	public function add($id = "", $title = "", $type = "", $name = "", $value = "", $size = 12, $required = false, $params = array(), $disabled="", $checked = "") {
		$this->fields[] = array(
			"id"       => $id,
			"title"    => $title,
			"type"     => $type,
			"name"     => $name,
			"value"    => $value,
			"size"     => $size,
			"required" => $required,
			"params"   => $params,
			"disabled" => $disabled,
			"checked"  => $checked,
		);
		return $this;
	}
	
	public function addHtml($html = "") {
		$this->fields[] = array(
				"id"       => "",
				"title"    => "",
				"type"     => "html",
				"name"     => "",
				"value"    => $html,
				"size"     => "",
				"required" => "",
				"params"   => "",
		);
	
		return $this;
	}
	
	public function setSubmit($title = "", $disabled="") {
		$this->submit = $title;
		$this->disabled = $disabled;
		return $this;
	}
	
	public function parse() {
		$this->rs .= '
			<form method="post" enctype="multipart/form-data" class="form-horizontal" ' . $this->formdata . ' >
		';
		
		foreach($this->fields as $field) {
		    $fname = (string)$field["type"];
		    $this->rs .= $this->$fname($field);
		}
		
		$this->rs .= '
                <div>
                    <button type="submit" class="btn btn-primary btn-sm" '. $this->disabled . '>
                        <i class="fa fa-dot-circle-o"></i> ' . $this->submit . '
                    </button>
                    <button type="reset" OnClick="history.back();" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Отмена
                    </button>
                </div>
			</form>
		';
		
		return $this->rs;
	}
	
	public function parseFields() {
		$this->rs = '';
		
		foreach($this->fields as $field) {	
		    $fname = (string)$field["type"];
		    $this->rs .= $this->$fname($field);
		}
	
		return $this->rs;
	}
	
	public function title($field = array()) {
		return 	'
			<div class="form-group col-sm-' . $field["size"] . '">
				<h3>' . $field["title"] . '</h3>
			</div>';
	}
	
	public function input($field = array()) {
		$tmp = '<input type="text" name="' . $field["name"] . '" class="form-control" id="' . $field["id"] . '" placeholder="' . $field["title"] . '" value="' . $field["value"] . '" ' . (($field["required"]) ? "required" : "" ) . ' autocomplete="off">';
		return $tmp;

	}
	public function file($field = array()) {
	    $tmp = '<input type="file" name="' . $field["name"] . '" class="form-control" id="' . $field["id"] . '" placeholder="' . $field["title"] . '" value="' . $field["value"] . '" ' . (($field["required"]) ? "required" : "" ) . ' autocomplete="off">';
	    return $tmp;
	}
	//!!!
	public function checkbox($field = array()) {
		$tmp = '<div class="row form-group">';
		
		if(!empty($field["title"])) {
			$tmp .= '<div class="col"><label for="' . $field["id"] . '" class="form-control-label">' . $field["title"] . '</label></div>';
		}
		
		$tmp .= '
			<div class="col">
				<input type="' . $field["type"] . '" name="' . $field["name"] . '" class="text-left" id="' . $field["id"] . '" placeholder="' . $field["title"] . '" value="' . 
				$field["value"] . '" ' . (($field["required"]) ? "required" : "" ) . (($field["checked"] === 1) ? "checked" : "" ).'>
			</div>';
		
		$tmp .= '</div>';
		
		return $tmp;
	}
	public function text($field = array()) {
		$tmp = '<div class="row form-group">';
		
		if(!empty($field["title"])) {
			$tmp .= '<div class="col col-md-12"><label for="' . $field["id"] . '" class="form-control-label">' . $field["title"] . '</label></div>';
		}
		
		$tmp .= '
			<div class="col col-md-12">
			 	<input type="' . $field["type"] . '" name="' . $field["name"] . '" class="form-control" id="' . $field["id"] . '" placeholder="' . $field["title"] . '" value="' . $field["value"] . '" ' . (($field["required"]) ? "required" : "" ) . ' '.$field["disabled"] . ' autocomplete="off">
			</div>';
		
		$tmp .= '</div>';
		
		return $tmp;
	}
	
	public function textarea($field = array()) {
		$tmp = '<div class="row form-group">';
	
		if(!empty($field["title"])) {
			$tmp .= '<div class="col col-md-12"><label for="' . $field["id"] . '" class="form-control-label">' . $field["title"] . '</label></div>';
		}
	
		$tmp .= '
			<div class="col col-md-12">
				<textarea name="' . $field["name"] . '" class="form-control" id="' . $field["id"] . '" placeholder="' . $field["title"] . '" ' . (($field["required"]) ? "required" : "" ) . '>' . $field["value"] . '</textarea>
			</div>';
	
		$tmp .= '</div>';
	
		return $tmp;
	}
	
	public function date($field = array()) {
		if(empty($field["value"])) {
			$field["value"] = date("d.m.Y");
		}
		
		return 	'
			<div class="row form-group">
                <div class="col col-md-12">
				    <label for="' . $field["id"] . '" class="form-control-label">' . $field["title"] . '</label>
                </div>
                <div class="col col-md-12">
    				<div class="controls">
    					<div  data-date="' . $field["value"] . '" class="input-append date datepicker">
    						<input name="' . $field["name"] . '" type="date" id="'.$field["id"].'" value="' . $field["value"] . '"  data-date-format="dd.mm.yyyy" class="form-control" placeholder="' . $field["title"] . '" ' . (($field["required"]) ? "required" : "" ).' '.$field["disabled"].'>
    						<span class="add-on"><i class="icon-th"></i></span>
    					</div>
    				</div>
                </div>
			</div>';
	}
	
	public function hidden($field = array()) {
		return 	'
			<input type="' . $field["type"] . '" name="' . $field["name"] . '" id="' . $field["id"] . '" value="' . $field["value"] . '" ' . (($field["required"]) ? "required" : "" ) . '>';
	}
	
	public function select($field = array()) {	    
		$rs = 	'<div class="row form-group">
                    <div class="col col-md-12">
					   <label for="' . $field["id"] . '" class="form-control-label">' . $field["title"] . '</label>
                    </div>
					<div class="col col-md-12">
			 			<select name="' . $field["name"] . '" id="' . $field["id"] . '" ' . (($field["required"]) ? "required" : "" ) . ' class="form-control"' . $field["disabled"] . '>';
		
		foreach($field["params"]["list"] as $value => $title) {
			/* ! */$rs .= 	'<option value="' . $value . '" ' . (($field["value"] == $value) ? "selected" : "" ) . '>' . $title . '</option>';
		}
		
		$rs .= 	'</select></div></div>';
				
		return $rs;
	}
	
	public function html($field = array()) {	
		$rs .= 	$field["value"];
	
		return $rs;
	}
	
	public function checklist($field = array()) {
		$rs = 	'<div class="row form-group">
                    <div class="col col-md-12">
					   <label for="' . $field["id"] . '">' . $field["title"] . '</label>
                    </div>
                    <div class="col col-md-12">
			 		  <select name="' . $field["name"] . '" class="form-control-label" id="' . $field["id"] . '" ' . (($field["required"]) ? "required" : "" ) . '>';
	
		foreach($field["params"]["list"] as $value => $title) {
			$rs .= 	'<option value="' . $value . '" ' . (($field["value"] == $value) ? "selected" : "" ) . '>' . $title . '</option>';
		}
	
		$rs .= 	'</select></div></div>';
	
		return $rs;
	}

	public function searchselect($field = array()) {	    
		$rs = 	'<div class="row form-group">
                    <div class="col col-md-12">
					   <label for="' . $field["id"] . '" class="form-control-label">' . $field["title"] . '</label>
                    </div>
					<div class="col col-md-12">
			 			<select data-live-search="true" name="' . $field["name"] . '" id="' . $field["id"] . '" ' . (($field["required"]) ? "required" : "" ) . ' class="selectpicker form-control"' . $field["disabled"] . '>';
		
		foreach($field["params"]["list"] as $value => $title) {
			/* ! */$rs .= 	'<option value="' . $value . '" ' . (($field["value"] == $value) ? "selected" : "" ) . '>' . $title . '</option>';
		}
		
		$rs .= 	'</select></div></div>';
				
		return $rs;
	}
	
}
