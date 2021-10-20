<?php

/**
 * @copyright 2016
 * @author Darkas
 * @copyright REDUIT Co.
 */
//test 
namespace RedCore;

use RedCore\Users\Collection as Users;
use RedCore\Request as Request;
use RedCore\Session as Session;
use RedCore\Config as Config;

class Controller
{
	public static $is_excel_file = false;
	public static $file_name = 'output';

	private static $url    = "";
	private static $page   = "";
	private static $action = "";

	private static $route = array(
		/*	ROUTE PAGES
		 * 
		 *	KEYS:
		 *		"title"  : title for main use. Values: string
		 *		"url"    : url for access in browser. Values: string
		 *		"view"   : path to php in views. Values: string
		 *		"content": path to php subview, if view used as template. Values: string
		 *		"tag"    : tags array. Values: mixed array
		 *		"default": default page. Values: "true", "false"
		 *
		 *	@TODO pages set and load in BD
		 */
		"pages" => array(
			/* AJAX
			 * 
			 * Not used: content, tags, default
			 * Example:
			 * 
			  	array(
					"title"    => "test",
					"url"      => "test",
					"view"     => "test/test/test.php",
					"content"  => "",
					"tag"      => array(),
				),
			 */


			/* DESKTOP
			 *
			 * Example:
			 *
				 array(
					 "title"    => "test",
					 "url"      => "test",
					 "view"     => "test/test/test.php",
					 "content"  => "test/test/subtest.php",
					 "tag"      => array("top"),
					 "default"  => true
				 ),
			 */
			array(
				"title"    => "Авторизация",
				"url"      => "auth",
				"view"     => "desktop/Users/auth.php",
				"content"  => "",
				"tag"      => array(),
				"auth"     => true,
			),

			array(
				"title"    => "Главная",
				"url"      => "home",
				"view"     => "desktop/page.php",
				"content"  => "desktop/dashboard/home.php",
				"tag"      => array("top"),
				"default"  => true,
				"access"   => array(
					"role" => array(1, 2, 3, 4, 5, 6),
				)
			),

			/*
			 ______________________________________________________________________________________________________________________________________________________
			 * Реестры 
			 ______________________________________________________________________________________________________________________________________________________
			 */


			// Пользователи
			array(
				"title"    => "Пользователи",
				"url"      => "users-list",
				"view"     => "desktop/page.php",
				"content"  => "desktop/Users/list.php",
				"tag"      => array("top", "admin"),
				"default"  => false,
			),

			array(
				"title"    => "Форма - Пользователи",
				"url"      => "users-form",
				"view"     => "desktop/page.php",
				"content"  => "desktop/users/form.php",
				"tag"      => array(),
				"access"   => array(
					"role" => array(1, 2, 19),
				),
			),

			array(
				"title"    => "Матрица доступа",
				"url"      => "accessmatrix-list",
				"view"     => "desktop/page.php",
				"content"  => "desktop/Users/accessMatrix.view.php",
				"tag"      => array("top", "admin"),
				"default"  => false,
			),

			array(
				"title"    => "Маршруты документов",
				"url"      => "doctyperolematrix-list",
				"view"     => "desktop/page.php",
				"content"  => "desktop/Users/docTypeRoleMatrix.view.php",
				"tag"      => array("top", "admin"),
				"default"  => false,
			),

			array(
				"title"    => "popupForChoosingStep",
				"url"      => "popupForChoosingStep",
				"view"     => "desktop/Users/ajax/popupForChoosingStep.php",
				"content"  => "",
				"tag"      => array(),
			),

			//Входящие документы
		    
			array(
		        "title"    => "Входящие документы",
		        "url"      => "indocitems-list",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/listindoc.php",
				"default"  => false,
		        "tag"      => array("top", "docs"),
		    ),
		    
		    
		    array(
		        "title"    => "В/Д форма",
		        "url"      => "indocitems-form-addupdate",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/formindoc.addupdate.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
			
			
		    array(
		        "title"    => "У/Д форма",
		        "url"      => "indocitems-form-delete",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/formindoc.delete.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
		    
		    array(
		        "title"    => "Форма просмотра документа",
		        "url"      => "indocitems-form-view",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/viewdoc.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
		    
		    array(
		        "title"    => "Документы типа: 'Черновик'",
		        "url"      => "indocitems-list-draft",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/MyDocs/listindocfordraft.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
		    
		    array(
		        "title"    => "Документы типа: 'Согласование'",
		        "url"      => "indocitems-list-agreement",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/MyDocs/listindocforagreement.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
		    
		    array(
		        "title"    => "Документы типа: 'Утверждение'",
		        "url"      => "indocitems-list-approval",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/MyDocs/listindocforapproval.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
		    
		    array(
		        "title"    => "Документы типа: 'Принятие'",
		        "url"      => "indocitems-list-adoption",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/MyDocs/listindocforadoption.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),

		    array(
		        "title"    => "Модальное окно для отправки по маршруту",
		        "url"      => "popupMovingRoute",
		        "view"     => "desktop/Indoc/ajax/popupMovingRoute.php",
		        "content"  => "",
		        "tag"      => array(),
		    ),
		    
		    array(
		        "title"    => "Скачивание документов",
		        "url"      => "docs-download",
		        "view"     => "desktop/Indoc/download.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),

			//Тип документов
		    
		    array(
		        "title"    => "Типы документов",
		        "url"      => "doctypes-list",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/listdoctypes.php",
		        "default"  => false,
		        "tag"      => array("top", "dictionary"),
		    ),
		    
		    array(
		        "title"    => "Тип документов форма",
		        "url"      => "doctypes-form",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/formdoctypes.addupdate.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
		    
		    
		    array(
		        "title"    => "Тип документов форма удаления",
		        "url"      => "doctypes-form-delete",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/Indoc/formdoctypes.delete.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),

			// Поиск

			array(
		        "title"    => "Модуль-Поиск",
		        "url"      => "searchitems-list",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/search/list.php",
				"default"  => false,
		        "tag"      => array("top", "docs"),
		    ),
		    array(
		        "title"    => "Поиск-форма-document",
		        "url"      => "searchitems-form_document",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/search/form_search_doc.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
			array(
		        "title"    => "Выгрузка в Excel",
		        "url"      => "searchitems-download",
		        "view"     => "desktop/Search/download.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
			array(
		        "title"    => "Фильтр",
		        "url"      => "searchitems-form",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/search/form.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
		    array(
		        "title"    => "Тест-Поиск",
		        "url"      => "searchtest-list",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/search/testsearch.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
            ),

			//Information documents module
			/*
			array(
		        "title"    => "Нормативно-справочная документация",
		        "url"      => "infodocs-mainlist",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/list.php",
				"default"  => false,
		        "tag"      => array("top", "dictionary"),
		    ),*/

			array(
		        "title"    => "Контрагенты",
		        "url"      => "infodocs-agents",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/agents_list.php",
				"default"  => false,
		        "tag"      => array("top", "infodoc"),
		    ),
			array(
		        "title"    => "Виды работ",
		        "url"      => "infodocs-works",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/works_list.php",
				"default"  => false,
		        "tag"      => array("top", "infodoc"),
		    ),
            array(
		        "title"    => "Материалы",
		        "url"      => "infodocs-materials",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/materials_list.php",
				"default"  => false,
		        "tag"      => array("top", "infodoc"),
		    ),
			array(
		        "title"    => "Нормы",
		        "url"      => "infodocs-standarts",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/standarts_list.php",
				"default"  => false,
		        "tag"      => array("top", "infodoc"),
		    ),

			
			array(
		        "title"    => "Форма редактирования справочника контрагентов",
		        "url"      => "infodocs-agentsform",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/agents_form.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
			
			array(
		        "title"    => "Форма редактирования справочника материалов",
		        "url"      => "infodocs-materialsform",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/materials_form.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
			
			array(
		        "title"    => "Форма редактирования справочника работ",
		        "url"      => "infodocs-worksform",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/works_form.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
			
			array(
		        "title"    => "Форма редактирования справочника норм",
		        "url"      => "infodocs-standartsform",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/standarts_form.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),
			/*
			array(
		        "title"    => "Контрагенты. Форма удаления",
		        "url"      => "infodocs-agentsdelete",
		        "view"     => "desktop/page.php",
		        "content"  => "desktop/infodocs/agents_delete.php",
		        "default"  => false,
		        "tag"      => array("top", ""),
		    ),*/
			

			/**
			 * INSTALL
			 */
			array(
				"title"    => "Настройка",
				"url"      => "install",
				"view"     => "system/install.php",
				"content"  => "",
				"tag"      => array(),
			),

			/**
			 * 404
			 */
			array(
				"title"    => "Ошибка доступа",
				"url"      => "error404",
				"view"     => "system/page404.php",
				"content"  => "",
				"tag"      => array(),
			),

			/**
			 * 403
			 */
			array(
				"title"    => "Доступ запрещен",
				"url"      => "error403",
				"view"     => "desktop/page.php",
				"content"  => "system/page403.php",
				"tag"      => array(),
			),
			/***
			 * general error
			 */
			array(
				"title"    => "Ошибка",
				"url"      => "generalError",
				"view"     => "desktop/page.php",
				"content"  => "system/generalError.php",
				"tag"      => array(),
			),
		),
		/*	______________________________________________________________________________________________________________________________________________________
		 *	ROUTE ACTIONS
		 *
		 *	KEYS:
		 *		"name"  : action unique name for using in frontend forms. Values: string
		 *		"module": real module object full path. Values: string
		 *		"method": real method of "module". Values: string
		 *		"params": list of params to transfer from $_REQUEST in "method". Values: string
		 *
		 *	@TODO actions set and load in BD
		 *  ______________________________________________________________________________________________________________________________________________________
		 */
		"actions" => array(
			/* AJAX
			 *
			 * Not used: content, tags, default
			 * Example:
			 *
				array(
					"name"   => "test.test.do",
					"module" => "RedCore\Test\Collection",
					"method" => "store",
					"params" => array(
						"test",
					),
				),
			 */
			// User actions
			array(
				"name"   => "user.store.do",
				"module" => "RedCore\Users\Collection",
				"method" => "store",
				"params" => array(
					"user",
				),
			),

			array(
				"name"   => "user.delete.do",
				"module" => "RedCore\Users\Collection",
				"method" => "delete",
				"params" => array(
					"user",
				),
			),
			array(
		        "name"   => "user.auth.do",
		        "module" => "RedCore\Users\Collection",
		        "method" => "auth",
		        "params" => array(
		            "user",
		        ),
		    ),
		    
		    array(
		        "name"   => "user.logout.do",
		        "module" => "RedCore\Users\Collection",
		        "method" => "logout",
		        "params" => array(
		            "user",
		        ),
			),
			array(
		        "name"   => "accessmatrix.store.do",
		        "module" => "RedCore\Users\Collection",
		        "method" => "accessmatrixStore",
		        "params" => array(
		            "accessmatrix",
		        ),
			),
			array(
		        "name"   => "doctyperolematrix.store.do",
		        "module" => "RedCore\Users\Collection",
		        "method" => "ajaxDocTypeRoleMatrixStore",
		        "params" => array(
		            "doctyperolematrix",
		        ),
			),
			//Infodocs actions
			
			array(
		        "name"   => "oinfodocsagents.store.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "store",
		        "params" => array(
		            "oinfodocsagents",
		        ),
		    ),
			
		    array(
		        "name"   => "oinfodocsagents.delete.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "delete",
		        "params" => array(
		            "oinfodocsagents",
		        ),
		    ),
			
			array(
		        "name"   => "oinfodocsworks.store.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "store",
		        "params" => array(
		            "oinfodocsworks",
		        ),
		    ),
			
		    array(
		        "name"   => "oinfodocsworks.delete.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "delete",
		        "params" => array(
		            "oinfodocsworks",
		        ),
		    ),
			
			array(
		        "name"   => "oinfodocsmaterials.store.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "store",
		        "params" => array(
		            "oinfodocsmaterials",
		        ),
		    ),
			
		    array(
		        "name"   => "oinfodocsmaterials.delete.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "delete",
		        "params" => array(
		            "oinfodocsmaterials",
		        ),
		    ),
			
			array(
		        "name"   => "oinfodocsstandarts.store.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "store",
		        "params" => array(
		            "oinfodocsstandarts",
		        ),
		    ),
			
		    array(
		        "name"   => "oinfodocsstandarts.delete.do",
		        "module" => "RedCore\Infodocs\Collection",
		        "method" => "delete",
		        "params" => array(
		            "oinfodocsmaterials",
		        ),
		    ),
			
			
			//Indoc actions
			array(
		        "name"   => "oindoc.store.do",
		        "module" => "RedCore\Indoc\Collection",
		        "method" => "store",
		        "params" => array(
		            "oindoc",
		        ),
		    ),
		    
		    array(
		        "name"   => "oindoc.delete.do",
		        "module" => "RedCore\Indoc\Collection",
		        "method" => "delete",
		        "params" => array(
		            "oindoc",
		        ),
		    ),
		    
			array(
		        "name"   => "oindoc.ajaxMoveRoute.do",
		        "module" => "RedCore\Indoc\Collection",
		        "method" => "ajaxMoveRoute",
		        "params" => array(
		            "oindoc",
		        ),
		    ),

			array(
		        "name"   => "doclog.ajaxRegisterDocLog.do",
		        "module" => "RedCore\Indoc\Collection",
		        "method" => "ajaxRegisterDocLog",
		        "params" => array(
		            "doclog",
		        ),
		    ),
			//DocType actions
		    array(
		        "name"   => "odoctypes.store.do",
		        "module" => "RedCore\Indoc\Collection",
		        "method" => "store",
		        "params" => array(
		            "odoctypes",
		        ),
		    ),
		    
		    array(
		        "name"   => "odoctypes.delete.do",
		        "module" => "RedCore\Indoc\Collection",
		        "method" => "delete",
		        "params" => array(
		            "odoctypes",
		        ),
		    ),
		   
	 	    //Search action)
		    array(
		        "name"   => "osearch.searchall.do",
		        "module" => "RedCore\Search\Collection",
		        "method" => "searchall",
		        "params" => array(
		            "oseacrh",
		        ),
		    ),
	    )
	);




	public static function Init()
	{
		Session::Init();

		self::$url = parse_url($_SERVER["REQUEST_URI"]);

		self::Action();

		self::Route(self::$url["path"]);

		self::Body();

		switch ($_SERVER["CONTENT_TYPE"]) {
			case "application/json":

				break;

			case "application/x-www-form-urlencoded":

				break;
			default:
				return false;
		}
	}

	private static function Body()
	{
		if (!self::isAccess(self::$page)) {
			$no_has_auth_page = true;

			foreach (self::$route["pages"] as $page) {
				if ($page["auth"]) {
					self::$page = $page;
					$has_auth_page = false;
				}
			}

			if ($has_auth_page) self::Redirect('error404');
		}

		if (self::$is_excel_file) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename(self::$file_name));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
		}

		ob_start();

		$path = CMS_VIEW . SEP . self::$page["view"];

		if (file_exists($path) and (is_file($path))) {
			include($path);
		} else {
			/*
			 * 404
			 */
			self::Redirect('error404');
		}

		ob_end_flush();
		exit();
	}

	private static function Route($link = "")
	{
		self::$page = false;

		
		if ("/" == $link) {
			foreach (self::$route["pages"] as $page) {
				if ($page["default"]) {
					self::$page = $page;
				}
			}
		} else {
			foreach (self::$route["pages"] as $page) {
				if ($link == (SEP . $page["url"])) {
					self::$page = $page;
				}
			}
		}

		if (!self::$page) {
			foreach (self::$route["pages"] as $page) {
				if ("page404" == (SEP . $page["url"])) {
					self::$page = $page;
				}
			}
		}
	}

	public static function Load()
	{
		$path = CMS_VIEW . SEP . self::$page["content"];

		if (file_exists($path) and (is_file($path))) {
			include($path);
		} else {
			echo "404";
			/*
			 * 404
			 */
		}
	}

	public static function Action()
	{
		$action_name  = Request::vars('action');
		self::$action = false;

		foreach (self::$route["actions"] as $action) {
			if ($action_name == $action["name"]) {
				self::$action = $action;
				break;
			}
		}

		if (self::$action) {
			$module   = (string)$action['module'];
			$method   = (string)$action['method'];
			$params   = (array)$action['params'];

			if (!is_array($params)) $params = array($params);

			$data = array();

			if (is_array($params)) {
				foreach ($params as $param) {
					$data[(string)$param] = Request::vars((string)$param);
				}
			}

			self::Obj($module)->setObject($param);
			self::Obj($module)->$method($data);
		}
		// var_dump(Request::vars('redirect'));
		if ($redirect = Request::vars('redirect')) {
			// echo "<script>window.location.href=
			// 	'$redirect'</script>";
			header('location: /' . $redirect);
		}
	}

	private static function Obj($class = '')
	{
		$obj = new $class;
		return $obj;
	}

	public static function Search($path = "pages", $tag = "")
	{
		$search  = self::$route[$path];
		$results = array();

		foreach ($search as $item) {
			if (in_array($tag, $item["tag"])) {
				$results[] = $item;
			}
		}

		return $results;
	}

	public static function getUrl()
	{
		return self::$url['path'];
	}

	public static function Redirect($redirect = "/")
	{
		header('location: ' . $redirect);
		//echo "<script>window.location.href='$redirect'</script>";
	}

	public static function isAccess($object = "")
	{
		//debug(Config::$auth);
		if (Config::$auth) {
			if (key_exists("access", $object)) {
				Users::setObject("user");

				if ($role = Users::getAuthRole()) {
					return (in_array($role, $object["access"]["role"]));
				}

				return false;
			}

			return true;
		}

		return true;
	}

	public static function isAuth()
	{
		return Users::isAuth();
	}
}