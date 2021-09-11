<?php

namespace RedCore;

use RedCore\Sites\Pages\Collection as Pages;

class Files {
	
	public static function delete($params = array()) {
		$files    = $params["files"];
		$filename = $files["filename"];
		$page_id  = $files["page_id"];
		$path     = $files["path"];
		$url      = $files["site_url"];
		
		$data['path'] = $path;
		$result       = sendRequest("delete-file", $url, $data);
		
		$lb_params = array(
			"id" => $page_id,
		);
		
		Pages::setObject("page");
		
		if($page = Pages::loadBy($lb_params)) {
			$page->params->titles = (array)$page->params->titles;
			unset($page->params->titles[$filename]);
			$page->store();
		}
	}
	
	public static function uploadTo($params = array()) {
		$files   = $params["files"];
		$page_id = $files["page_id"];
		$path    = "page" . $page_id;
		$url     = $files["site_url"];
		$title   = $files["title"];
	
		if($file = self::upload("files", "file")) {
			$data['file'] = '@' . CMS_TMP . SEP . $file;
			$data['path'] = $path;
			$file_title = sendRequest("upload-file", $url, $data);
			unlink(CMS_TMP . SEP . $file);
			
			$lb_params = array(
				"id" => $page_id,	
			);
			
			Pages::setObject("page");
			
			if($page = Pages::loadBy($lb_params)) {
				$page->params->titles = (array)$page->params->titles;
				$page->params->titles[$file_title] = $title;
				$page->store();
			}
			
		}
	}
	
	public static function upload($html_object = '', $field = '') {		
		if(isset($_FILES[$html_object]['tmp_name'][$field])) {
			$tmp  = $_FILES[$html_object]['tmp_name'][$field];
			$name = $_FILES[$html_object]['name'][$field];
			$ext  = end(explode(".", $name));
			$title = md5(uniqid()) . "." . $ext;
			$filepath = CMS_TMP . SEP . $title;

			if(move_uploaded_file($tmp, $filepath)) {
				return $title;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
}
