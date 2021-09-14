<?
/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore;

ini_set('display_errors','On');
// ini_set('display_errors','Off');
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_WARNING ^ E_DEPRECATED );
if(isset($_REQUEST["test-info"])) {
	ini_set('display_errors','On');
	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_WARNING ^ E_DEPRECATED );
}


define('SEP'          , '/');
define('CMS_DIR'      , $_SERVER['DOCUMENT_ROOT'] . SEP . 'core');
define('CMS_TEMPLATE' , $_SERVER['DOCUMENT_ROOT'] . SEP . 'template');
define('CMS_IMAGES'   , $_SERVER['DOCUMENT_ROOT'] . SEP . 'images');
define('CMS_TMP'      , CMS_IMAGES . SEP . 'tmp');
define('CMS_HELPER'   , CMS_DIR . SEP . 'helpers');
define('CMS_MODULE'   , CMS_DIR . SEP . 'modules');
define('CMS_VIEW'     , CMS_DIR . SEP . 'view');
define('IMAGES'       , SEP . 'images');
define('NO_IMAGE'     , IMAGES . SEP . 'nophoto.jpg');


require_once(CMS_DIR    . SEP . 'config.php');
/*
 * Helpers
 */
require_once(CMS_HELPER . SEP . 'db/db.php');
require_once(CMS_HELPER . SEP . 'phpmailer/class.phpmailer.php');
require_once(CMS_HELPER . SEP . 'tcpdf/tcpdf.php');
require_once(CMS_HELPER . SEP . 'base/collection.php');
require_once(CMS_HELPER . SEP . 'helper.php');
require_once(CMS_HELPER . SEP . 'forms.php');
require_once(CMS_HELPER . SEP . 'session.php');
require_once(CMS_HELPER . SEP . 'response.php');
require_once(CMS_HELPER . SEP . 'validator.php');
require_once(CMS_HELPER . SEP . 'request.php');
require_once(CMS_HELPER . SEP . 'files.php');

/*
 * Modules
 */
require_once(CMS_MODULE . SEP . 'Users/collection.php');
require_once(CMS_MODULE . SEP . 'Indoc/collection.php');
require_once(CMS_MODULE . SEP . 'DocTypes/collection.php');
require_once(CMS_MODULE . SEP . 'Search/collection.php');

require_once(CMS_MODULE . SEP . 'logger/collection.php');

/*
 * Controller
 */
require_once(CMS_DIR    . SEP . 'controller.php');

/*
 * Plugins
 */

require_once(CMS_TEMPLATE . SEP . 'general/custom/PHPExcel/PHPExcel.php');



class Core {
	/**
	 * Экземпляр класса DB
	 * Вся работа с базой только через UTF-8
	 * @var DB $db
	 */
	public static $db = '';
	
	public static function Init() {
		if (Config::$db) {
			self::$db = new db();
			self::$db->connect();
			mysqli_set_charset(utf8);
			// mysql_set_charset(utf8);
			mb_internal_encoding("UTF-8");
			self::$db->execute('SET SQL_BIG_SELECTS=1');
		}
	}
}

Core::Init();	
Controller::Init();		
?>