<?php

class StandartObject { 
	
	public function setParams($params = array()) {	
		foreach($params as $param => $value) {
			$this->$param = $value;
		}	
		
		return $this;
	}
	
}