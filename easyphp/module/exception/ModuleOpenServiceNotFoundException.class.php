<?php

/**
 * This Object represents a Exception to tell users that the module open service is not exists.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-2-29
 */

class ModuleOpenServiceNotFoundException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setModule($module){
		$this->putData('module', $module);
	}
	
	public function getModule(){
		return $this->getData('module');
	}
	
	public function setService($service){
		$this->putData('service', $service);
	}
	
	public function getService(){
		return $this->getData('service');
	}
}