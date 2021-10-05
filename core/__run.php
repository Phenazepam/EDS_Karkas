<?
/**
 * @copyright 2017
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore;

ini_set('display_errors','On');
// if(isset($_REQUEST["test-info"])) {
// 	ini_set('display_errors','On');
// 	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_WARNING ^ E_DEPRECATED );
// }



define('SEP'          , '/');
define('CMS_DIR'      , $_SERVER['DOCUMENT_ROOT'] . SEP . 'core');
define('CMS_TEMPLATE' , $_SERVER['DOCUMENT_ROOT'] . SEP . 'template');
define('CMS_IMAGES'   , $_SERVER['DOCUMENT_ROOT'] . SEP . 'images');
define('CMS_TMP'      , CMS_IMAGES . SEP . 'tmp');
define('CMS_HELPER'   , CMS_DIR . SEP . 'helpers');
define('CMS_MODULE'   , CMS_DIR . SEP . 'modules');
define('CMS_VIEW'     , CMS_DIR . SEP . 'view');
define('IMAGES'       , SEP . 'images');
define('NO_IMAGE'     , IMAGES . SEP . 'nophoto2.jpg');


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
require_once(CMS_MODULE . SEP . 'Buildings/collection.php');
require_once(CMS_MODULE . SEP . 'Partner/collection.php');
require_once(CMS_MODULE . SEP . 'SaleObject/collection.php');
require_once(CMS_MODULE . SEP . 'FacingTypes/collection.php');
require_once(CMS_MODULE . SEP . 'ContractTypes/collection.php');
require_once(CMS_MODULE . SEP . 'AccountingEntity/collection.php');
require_once(CMS_MODULE . SEP . 'ContractStatus/collection.php');
require_once(CMS_MODULE . SEP . 'Promotion/collection.php');
require_once(CMS_MODULE . SEP . 'Agency/collection.php');
require_once(CMS_MODULE . SEP . 'CalculationForm/collection.php');
require_once(CMS_MODULE . SEP . 'SaleType/collection.php');
require_once(CMS_MODULE . SEP . 'MortgageBank/collection.php');
require_once(CMS_MODULE . SEP . 'Contract/collection.php');
require_once(CMS_MODULE . SEP . 'ObjectStatus/collection.php');
require_once(CMS_MODULE . SEP . 'Buildings/collection.php');
require_once(CMS_MODULE . SEP . 'Flats/collection.php');
require_once(CMS_MODULE . SEP . 'FlatLayout/collection.php');
require_once(CMS_MODULE . SEP . 'Expenditure/collection.php');
// require_once(CMS_MODULE . SEP . 'Expenditure/ExpenditureSecond/collection.php');
// require_once(CMS_MODULE . SEP . 'Expenditure/ExpenditureThird/collection.php');
require_once(CMS_MODULE . SEP . 'Liter/collection.php');
require_once(CMS_MODULE . SEP . 'ResidentialComplex/collection.php');
require_once(CMS_MODULE . SEP . 'Budget/BankEscrow/collection.php');
require_once(CMS_MODULE . SEP . 'Project/collection.php');
require_once(CMS_MODULE . SEP . 'ProjectStatus/collection.php');
require_once(CMS_MODULE . SEP . 'BudgetPartner/collection.php');
require_once(CMS_MODULE . SEP . 'BudgetContract/collection.php');
require_once(CMS_MODULE . SEP . 'CalendarPlan/collection.php');
require_once(CMS_MODULE . SEP . 'PaymentDocument/collection.php');
require_once(CMS_MODULE . SEP . 'BudgetCalc/collection.php');
require_once(CMS_MODULE . SEP . 'logger/collection.php');

/*
 * Controller
 */
require_once(CMS_DIR    . SEP . 'controller.php');




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
			// mysqli_set_charset(utf8);
			mysqli_set_charset(utf8);
			mb_internal_encoding("UTF-8");
			self::$db->execute('SET SQL_BIG_SELECTS=1');
		}
	}
}

Core::Init();	
Controller::Init();		
?>