<?php

/**
 * This Object represent a exception to tell users that an exception occur 
 * while the method is been invoked.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-14
 */

class MethodInvokeException extends EasyException{
	
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