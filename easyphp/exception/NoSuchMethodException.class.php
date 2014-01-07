<?php

/**
 * This Object represents a Exception to tell users that the method he/she invoked 
 * is not found in object context.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-14
 */

class NoSuchMethodException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setMethod($method=''){
		$this->putData('method', $method);
	}
	
	public function getMethod(){
		return $this->getData('method');
	}
}