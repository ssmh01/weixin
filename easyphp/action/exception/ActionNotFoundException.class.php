<?php

/**
 * This Object represents a Exception to tell users that the Action 
 * is not found for the ActionMapping.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-20
 */

class ActionNotFoundException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setRequestURI($requestUIR){
		$this->putData('__request_uri', $requestUIR);
	}
	
	public function getRequestURI(){
		return $this->getData('__request_uri');
	}
}