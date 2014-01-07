<?php

/**
 * 
 * 数据库连接参数类
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-06-03
 */
class ConnectParameter{
	
	/**
	 * 数据库连接地址
	 */
	private $host;
	
	/**
	 * 数据库用户名
	 */
	private $user;
	
	/**
	 * 数据库用户密码
	 */
	private $password;
	
	/**
	 * 数据库名称
	 */
	private $database;
	
	/**
	 * 数据库编码
	 */
	private $charset;
	
	/**
	 * @return the $host
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * @param field_type $host
	 */
	public function setHost($host) {
		$this->host = $host;
	}

	/**
	 * @return the $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param field_type $user
	 */
	public function setUser($user) {
		$this->user = $user;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param field_type $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return the $database
	 */
	public function getDatabase() {
		return $this->database;
	}

	/**
	 * @param field_type $database
	 */
	public function setDatabase($database) {
		$this->database = $database;
	}

	/**
	 * @return the $charset
	 */
	public function getCharset() {
		return $this->charset;
	}

	/**
	 * @param field_type $charset
	 */
	public function setCharset($charset) {
		$this->charset = $charset;
	}
}