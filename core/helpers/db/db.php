<?php
/**
 * @copyright 2016
 * @author Darkas
 * @copyright REDUIT Co.
 */

namespace RedCore;

class Db {
	/**
	* Примечание:  
	* Используем библиотеку ADODB
	* Fast Functions:
	* Connect, PConnect, NConnect, Execute, CacheExecute
	* SelectLimit, CacheSelectLimit, MoveNext, Close
	* qstr, Affected_Rows, Insert_ID
	*
	* @author Darkas
	*
	*/

	public $adoConnection = null;

	private $type          = '';
	private $host          = '';
	private $user          = '';
	private $password      = '';
	private $database      = '';
	private $tablePrefix   = '';
	private $defaultPrefix = '';

	private $fetchMode = '';
	private $genId     = '';
	private $insertId  = '';
	
	private $cacheSecs        = 0;
	private $cntQueries       = 0;
	private $executeTime      = 0;
	private $lastExecuteTime  = 0;
	private $startExecuteTime = 0;
	private $stopExecuteTime  = 0;

	/**
	 * Создание нового подключения
	 * 
	 * @param string $dbType Драйвер базы данных.
	 * @param string $tablePrefix Префикс таблиц.
	 * @param string $dbCacheDir Директория кэштрованных запросов.
	 */
	public function __construct($dbType = '', $tablePrefix = '', $dbCacheDir = '') {
		if (!$dbType) {
			$dbType = Config::$dbType;
		}
		
		if (!$tablePrefix) {
			$tablePrefix = Config::$dbTablePrefix;
		}
		
		if (!$dbCacheDir) {
			$dbCacheDir = CMS_ROOT_DIR.'/cache/db';
		}
		
		$this->tablePrefix   = $tablePrefix;
		$this->defaultPrefix = Config::$dbTablePrefix;
		$this->type = $dbType;

		require_once(CMS_HELPER . SEP . 'db/adodb/adodb.inc.php');
		require_once(CMS_HELPER . SEP . 'db/adodb/adodb-errorhandler.inc.php');

		$ADODB_CACHE_DIR = $dbCacheDir;
		
		$this->adoConnection = ADONewConnection($this->type);
		$this->adoConnection->debug = Config::$dbDebug;
	}     

	/**
	 * Соединение с базой данных.
	 *
	 * @param string $host Сервер расположения базы данных.
	 * @param string $user Имя пользователя для подключения.
	 * @param string $password Пароль подключения к базе данных.
	 * @param string $database Имя базы данных.
	 */
	public function connect($host = '', $user = '', $password = '', $database = '') {
		$this->host     = (!empty($host))     ? $host     : Config::$dbHost;
		$this->user     = (!empty($user))     ? $user     : Config::$dbUser;
		$this->password = (!empty($password)) ? $password : Config::$dbPassword;
		$this->database = (!empty($database)) ? $database : Config::$dbName;

		$this->adoConnection->Connect($this->host, $this->user, $this->password, $this->database);
		$this->cacheSecs = $this->adoConnection->cacheSecs = 60 * 30;
	}

	/**
	 * Проверка соединения с базой данных.
	 */
	public function isConnected() {
		return $this->adoConnection->IsConnected();
	}

	/**
	 * Выполнение запроса.
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param array $inputarr Массив данных связки.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * @param mixed $cache Кэширование запроса. Если (bool) true, используется
	 * время кэша по умолчанию (30 минут). 
	 * 
	 * @return array Набор записей.
	 */
	public function execute($sql, $inputarr = false, $defaultPrefix = false, $cache = false) {
		$sql = $this->addPrefix($sql, $defaultPrefix);

		if (true === $cache) {
			$cache = $this->cacheSecs;
		}
		
		$this->cntQueries();
		$this->startQueryTime();

		$rs = ($cache && 0 === strpos($sql, 'SELECT'))
			? $this->adoConnection->CacheExecute($cache, $sql, $inputarr)
			: $this->adoConnection->Execute($sql, $inputarr);
		
		$this->stopQueryTime();
		
		return $rs;
	}
	
	/**
	 * Упрощает процедуры, выполняемые функциями-преобразователями GetInsertSQL() и GetUpdateSQL()
	 *
	 * @param string $table Имя таблицы.
	 * @param array $fieldsValues Ассоциированный массив полей 'fieldname'->'value'.
	 * @param string $mode. Режим вставки или обновления.
	 * @param string $where Условие.
	 * @param bool $forceUpdate Проверка существования текущего значения.
	 * @param bool $magicq Квотирование.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 */
	public function autoExecute($table, $fieldsValues, $mode = 'INSERT', $where = false, $forceUpdate = true, $magicq = false, $defaultPrefix = false) {
		$table = $this->addPrefix($table, $defaultPrefix);
		
		$this->cntQueries();
		$this->startQueryTime();
		$this->adoConnection->AutoExecute($table, $fieldsValues, $mode, $where, $forceUpdate, $magicq);
		
		$this->stopQueryTime();
	}
	
	/**
	 * Замена/вставка записи.
	 * 
	 * Выполняет оператор REPLACE.
	 *
	 * @param string $table Имя таблицы.
	 * @param array $fieldsValues Ассоциированный массив полей 'fieldname'->'value'.
	 * @param string $key. PRIMARY индекс таблицы.
	 * @param bool $autoQuote Квотирование.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 */
	public function replace($table, $fieldsValues, $key, $autoQuote = false, $defaultPrefix = false) {
		$table = $this->addPrefix($table, $defaultPrefix);
		
		$this->cntQueries();
		$this->startQueryTime();
		
		$this->adoConnection->Replace($table, $fieldsValues, $key, $autoQuote);
		
		$this->stopQueryTime();
	}
	
	/**
	 * Выполнение запроса и возврат в виде array(['col1']=>'v0', ['col2'] =>'v1')).
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param array $inputarr Массив данных связки.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * @param mixed $cache Кэширование запроса. Если (bool) true, используется
	 * время кэша по умолчанию (30 минут).
	 * 
	 * @return array Набор записей.
	 */
	public function executeAssoc($sql, $inputarr = false, $defaultPrefix = false, $cache = false) {
		$this->setFetchMode(ADODB_FETCH_ASSOC);
		
		return $this->execute($sql, $inputarr, $cache, $defaultPrefix);
	}

	/**
	 * Выполнение запроса и возврат в виде array([0]=>'v0', [1] =>'v1')).
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param array $inputarr Массив данных связки.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * @param mixed $cache Кэширование запроса. Если (bool) true, используется
	 * время кэша по умолчанию (30 минут).
	 * 
	 * @return array Набор записей.
	 */
	public function executeNum($sql, $inputarr = false, $defaultPrefix = false, $cache = false) {
		$this->setFetchMode(ADODB_FETCH_NUM);
		
		return $this->execute($sql, $inputarr, $cache, $defaultPrefix);
	}

	/**
	 * Устанока режима выборки.
	 *
	 * @param string $mode Режим возвращаемых значений.
	 */
	public function setFetchMode($mode) {
		$this->fetchMode = $mode;
		$this->adoConnection->SetFetchMode($this->fetchMode);
	}

	/**
	 * Генерирует id для выбранного объекта и хранит его значение в genId.
	 *
	 * @param seqname string Последовательность для использования генерации.
	 * @param startId integer Если не задана последовательность, генерация 
	 * начинается с этого id. 
	 */
	public function genId($seqname = 'adodbseq', $startId = 1) {
		return $this->genId = $this->adoConnection->GenID($seqname, $startId);
	}

	/**
	 * Получение id после добавления.
	 *
	 * @param string $table Имя таблицы.
	 * @param string $column Имя колонки.
	 * 
	 * @return integer $id последней вставленной записи.
	 */
	public function insertId($table = '', $column = '') {
		$table = $this->addPrefix($table);
		
		return $this->insertId = $this->adoConnection->Insert_ID($table, $column);
	}
	
	/**
	 * Подсчет запросов к базе дынных.
	 */
	private function cntQueries() {
		$this->cntQueries = ++$this->cntQueries;
	}

	/**
	 * Количество запросов к базе данных.
	 */
	public function getCntQueries() {
		return $this->cntQueries;
	}

	/**
	 * Начало времени выполнения запроса.
	 * 
	 * @return float Время начала.
	 */
	private function startQueryTime() {
		$this->startExecuteTime = microtime();
		
		return $this->startExecuteTime;
	}

	/**
	 * Окончание выполнения запроса.
	 * 
	 * @return float Время окончания.
	 */
	private function stopQueryTime() {
		$this->stopExecuteTime = microtime();
		$this->lastExecuteTime = (float) $this->stopExecuteTime - (float) $this->startExecuteTime;
		$this->executeTime     = (float) $this->executeTime     + (float) $this->lastExecuteTime;
		
		return $this->stopExecuteTime;
	}

	/**
	 * Время выполнения последнего запроса.
	 * 
	 * @return float Время запроса.
	 */
	public function getLastExecuteTime() {
		return $this->lastExecuteTime;
	}

	/**
	 * Общее время выполнения запросов.
	 * 
	 * @return float Время запросов.
	 */
	public function getExecuteTime() {
		return $this->executeTime;
	}

	/**
	 * Подготовка запроса.
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * 
	 * @return array Подготовленный запрос.
	 */
	public function prepare($sql, $defaultPrefix = false) {
		$sql = $this->addPrefix($sql, $defaultPrefix);

		return $this->adoConnection->Prepare($sql);
	}

	/**
	 * Выполнение запроса и возврат одной записи.
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param array $inputarr Массив данных связки.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * @param mixed $cache Кэширование запроса. Если (bool) true, используется время 
	 * кэша по умолчанию (30 минут).
	 * 
	 * @return array Набор записей.
	 */
	public function getRow($sql, $inputarr = false, $defaultPrefix = false, $cache = false) {
		$sql = $this->addPrefix($sql, $defaultPrefix);

		if (true === $cache) {
			$cache = $this->cacheSecs;
		}

		$this->cntQueries();
		$this->startQueryTime();

		$row = ($cache)
			? $this->adoConnection->CacheGetRow($cache, $sql, $inputarr)
			: $this->adoConnection->GetRow($sql, $inputarr);

		$this->stopQueryTime();
		
		return $row;
	}
	
/**
	 * Выполнение запроса и возврат одной колонки.
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param array $inputarr Массив данных связки.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * @param mixed $cache Кэширование запроса. Если (bool) true, используется время 
	 * кэша по умолчанию (30 минут).
	 * 
	 * @return array Набор записей.
	 */
	public function getCol($sql, $inputarr = false, $defaultPrefix = false, $cache = false) {
		$sql = $this->addPrefix($sql, $defaultPrefix);

		if (true === $cache) {
			$cache = $this->cacheSecs;
		}

		$this->cntQueries();
		$this->startQueryTime();

		$col = ($cache)
			? $this->adoConnection->CacheGetCol($cache, $sql, $inputarr)
			: $this->adoConnection->GetCol($sql, $inputarr);

		$this->stopQueryTime();
		
		return $col;
	}
	
	/**
	 * Выполнение запроса и возврат одного поля.
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param array $inputarr Массив данных связки.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * @param mixed $cache Кэширование запроса. Если (bool) true, используется время 
	 * кэша по умолчанию (30 минут).
	 * 
	 * @return array Набор записей.
	 */
	public function getOne($sql, $inputarr = false, $defaultPrefix = false, $cache = false) {
		$sql = $this->addPrefix($sql, $defaultPrefix);

		if (true === $cache) {
			$cache = $this->cacheSecs;
		}

		$this->cntQueries();
		$this->startQueryTime();

		$field = ($cache)
			? $this->adoConnection->CacheGetOne($cache, $sql, $inputarr)
			: $this->adoConnection->GetOne($sql, $inputarr);

		$this->stopQueryTime();
		
		return $field;
	}
	
	/**
	 * Добавление префикса таблицы для текущего подключения.
	 * 
	 * Все таблицы во всех запросах должны быть вида: {table_name}.
	 *
	 * @param string $sql Текст SQL запроса.
	 * @param bool $defaultPrefix Для таблиц использовать префикс по умолчанию.
	 * 
	 * @return string Текст SQL запроса c добавленным префиксом.
	 */
	private function addPrefix($sql, $defaultPrefix = false) {
		if (is_string($sql)) {
			return (0 === strpos($this->type, 'mysql'))
				? preg_replace('/{([a-z_-]+)}/', '`'.(($defaultPrefix) ? $this->defaultPrefix : $this->tablePrefix).'-$1`', $sql)
				: preg_replace('/{([a-z_-]+)}/', (($defaultPrefix) ? $this->defaultPrefix : $this->tablePrefix).'-$1', $sql);
		}
		else {
			return $sql;
		}
	}
	
	/** Заключение данных в кавычки
      *
      * @param string $string Данные
      *
      * @return string Данные в кавычках
      */
     public function quote($string = '') {
          return $this->adoConnection->qstr($string, get_magic_quotes_gpc());
     }
}

class Where {
	private $rs = '';
	
	public static function Cond() {
		$obj = new Where;
		$obj->rs = '';
		return $obj;	
	}
	
	public function add($field = '', $cond = '', $value = ''){
		
		
		if('and' == $field) {
			$this->rs .= 'and';
		}
		elseif('or' == $field) {
			$this->rs .= 'or';
		}
		elseif('not' == $field){
			$this->rs .= 'not';
		}
		elseif('in' == $cond) {
			$this->rs .= "($field $cond $value)";
		}
		elseif('not in' == $cond) {
			$this->rs .= "($field $cond $value)";
		}
		elseif(empty($cond)) {
			$this->rs .= "($field)";
		}
		else {
			$value = Core::$db->quote($value);
			$this->rs .= "($field $cond $value)";
		}
		
		return $this;
	}
	
	public function parse(){
		if(!empty($this->rs)) {
			$this->rs = ' WHERE ' . $this->rs;
		}
		return $this->rs;
	}
	
	public function result(){
		return $this->rs;
	}
}

class Query {
	
	public static function Select($fields, $table) {
		$obj = new Query;
		$rs = 'SELECT ' . implode(', ', $fields) . ' FROM ' . $table;
		return $rs;	
	}
}