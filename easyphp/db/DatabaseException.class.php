<?php

/**
 * This class is represent a exception to show error message of database operations.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-06-3
 */
class DatabaseException extends Exception{
	
	/**
	 * error message
	 */
	private $errorMessage;
	
	/**
	 * error code
	 */
	private $errorCode;
	
	/**
	 * sql statament
	 */
	private $sql;
	
	/**
	 * connect parameter.
	 */
	private $connectParameter;
	
	function __construct($errorMessage, $errorCode){
		$this->setErrorMessage($errorMessage);
		$this->setErrorCode($errorCode);
	}
	
	/**
	 * @return the $errorMessage
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}

	/**
	 * @return the $errorCode
	 */
	public function getErrorCode() {
		return $this->errorCode;
	}

	/**
	 * @return the $sql
	 */
	public function getSql() {
		return $this->sql;
	}

	/**
	 * @return the $connectParameter
	 */
	public function getConnectParameter() {
		return $this->connectParameter;
	}

	/**
	 * @param string $errorMessage
	 */
	public function setErrorMessage($errorMessage) {
		$this->errorMessage = $errorMessage;
	}

	/**
	 * @param int $errorCode
	 */
	public function setErrorCode($errorCode) {
		$this->errorCode = $errorCode;
	}

	/**
	 * @param string $sql
	 */
	public function setSql($sql) {
		$this->sql = $sql;
	}

	/**
	 * @param ConnectParameter $connectParameter
	 */
	public function setConnectParameter($connectParameter) {
		$this->connectParameter = $connectParameter;
	}
}