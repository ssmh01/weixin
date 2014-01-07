<?php

/**
 * The parent excetpion of mvc framework.
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-14
 */

class EasyException extends Exception{
	
	private $data;
	
	function __construct($message, $code){
		parent::__construct($message, $code);
		$data = array();
	}
		
	function putData($key, $value){
		$this->data[$key] = $value;
	}
	
	function getData($key){
		return $this->data[$key];
	}
}