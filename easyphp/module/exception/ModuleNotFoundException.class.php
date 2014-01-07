<?php

/**
 * This Object represents a Exception to tell users that the module is not exists.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-3-15
 */

class ModuleNotFoundException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setModule($module){
		$this->putData('module', $module);
	}
	
	public function getModule(){
		return $this->getData('module');
	}
}