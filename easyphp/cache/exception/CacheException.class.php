<?php

/**
 * The excetpion of cache framework.
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-04-18
 */

class CacheException extends Exception{
	
	private $data;
	
	function __construct($message){
		parent::__construct($message);
		$data = array();
	}
	
	function putData($key, $value){
		$this->data[$key] = $value;
	}
	
	function getData($key){
		return $this->data[$key];
	}
}