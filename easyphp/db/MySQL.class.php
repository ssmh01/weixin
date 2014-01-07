<?php
$databaseRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
include_once($databaseRoot . 'DatabaseAccesser.php');
include_once($databaseRoot . 'ConnectParameter.php');
include_once($databaseRoot . 'DatabaseException.php');
include_once($databaseRoot . 'SQL.php');

/**
 * MySQL数据库访问类
 * @author blueyb.java@gmail.com
 * @since 1.0 -	2011.06.02
 * @todo 用来访问MySQL数据数据库
 * @see DB
 */
class MySQL implements DB {
	
	/**
	 * 当前的连接参数
	 */
	private $connectParameter;
	
	/**
	 * 当前连接
	 */
	private $link = null;
	
	/*
	 * @see DatabaseAccesser::getConnectParameter()
	 */
	public function getConnectParameter() {
		return $this->connectParameter;
	}
	
	/*
	 * @see DatabaseAccesser::setConnectParameter()
	 */
	public function setConnectParameter($connectParameter) {
		$this->connectParameter = $connectParameter;
	}
	
	/*
	 * @see DatabaseAccesser::connect()
	 */
	public function connect($connectParameter) {
		if(empty($connectParameter)){
			$connectParameter = $this->getConnectParameter();
		}else{
			$this->setConnectParameter($connectParameter);
		}
		if(!$this->link = @mysql_connect($connectParameter->getHost(), $connectParameter->getUser(), $connectParameter->getPassword())) {
			throw new DatabaseException("Could not connect: " . $this->getError(), $this->getErrorCode());
		}
		$version = $this->getVersion();
		if($version > '4.1') {
			if($connectParameter->getCharset()) {
				mysql_query('SET character_set_connection='.$connectParameter->getCharset().', character_set_results='.$connectParameter->getCharset().', character_set_client=binary', $this->link);
			}
			if($version > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}
		if($connectParameter->getDatabase()){
			$success = mysql_select_db($connectParameter->getDatabase(), $this->link);
			if(!success){
				throw new DatabaseException("Could not select database: {$connectParameter->getDatabase()}, " . $this->getError(), $this->getErrorCode());
			}
		}
	}
	
	/*
	 * @see DatabaseAccesser::query()
	 */
	public function query($sql) {
		//发布后可以把下面的语句删除以提高效率
// 		if(get_config('debug_enable')){
// 			$log = R::getLog();
// 			$log->debug($sql, __FILE__, __LINE__);
// 		}
		$query = mysql_query($sql, $this->link);
		if(!$query){
			$e = new DatabaseException($this->getError(), $this->getErrorCode());;
			$e->setSql($sql);
			throw $e; 
		}
		return $query;
	}
	
	/*
	 * @see DatabaseAccesser::getRow()
	 */
	public function getRow($sql, $row) {
		$query = $this->query($sql);
		return $this->getRowFromQuery($query, $row);
	}
	
	/*
	 * @see DatabaseAccesser::getRowFromQuery()
	 */
	public function getRowFromQuery($query, $row) {
		return (!isset($row))? mysql_fetch_assoc($query) : mysql_result($query, $row);
	}
	
	/*
	 * @see DatabaseAccesser::getRows()
	 */
	public function getRows($sql, $count) {
		$query = $this->query($sql);
		return $this->getRowsFromQuery($query, $count);
	}
	
	/*
	 * @see DatabaseAccesser::getRowsFromQuery()
	 */
	public function getRowsFromQuery($query, $count) {
		$result = array();
		while ($row = $this->getRowFromQuery($query)) {
			$result[] = $row;
			if($count != 0 && count($result) >= $count){
				break;
			}
		}
		return $result;
	}
	
	/*
	 * @see DatabaseAccesser::getRowFiled()
	 */
	public function getRowFiled($sql, $row = 0, $field = 0) {
		$query = $this->query($sql);
		return $this->getRowFiledFromQuery($query, $row, $field);
	}

	/*
	 * @see DatabaseAccesser::getRowFiledFromQuery()
	 */
	public function getRowFiledFromQuery($query, $row = 0, $field = 0) {
		return mysql_result($query, $row, $field);
	}
	
	/*
	 * @see DatabaseAccesser::affectedRows()
	 */
	public function affectedRows() {
		return mysql_affected_rows($this->link);
	}
	
	/*
	 * @see DatabaseAccesser::rowCount()
	 */
	public function rowCount($query) {
		 return mysql_num_rows($query);
	}
	
	/*
	 * @see DatabaseAccesser::filedCount()
	 */
	public function filedCount($query){
		return mysql_num_fields($query);
	}
	
	/*
	 * @see DatabaseAccesser::getError()
	 */
	public function getError() {
		return ($this->link)? mysql_error($this->link) : mysql_error();
	}
	
	/*
	 * @see DatabaseAccesser::getErrorCode()
	 */
	public function getErrorCode() {
		return ($this->link)? mysql_errno($this->link) : mysql_errno();
	}
	
	/*
	 * @see DatabaseAccesser::freeQuery()
	 */
	public function freeQuery($query) {
		return @mysql_free_result($query);
	}
	
	/*
	 * @see DatabaseAccesser::getInsertId()
	 */
	public function getInsertId() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->getRowFiled("SELECT last_insert_id()", 0, 0);
	}
	
	/*
	 * @see DatabaseAccesser::getVersion()
	 */
	public function getVersion() {
		return @mysql_get_server_info($this->link);
	}
	
	/*
	 * @see DatabaseAccesser::close()
	 */
	public function close() {
		if(!@mysql_close($this->link)){
			throw new DatabaseException("Could not close: " . $this->getError(), $this->getErrorCode());
		}
	}
	
	/**
	 * 销毁对象，关闭数据库连接
	 */
	public function __destruct(){
		$this->close();
	}
}
?>
