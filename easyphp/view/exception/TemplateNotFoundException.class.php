<?php

/**
 * This Object represents a Exception to tell users that the template is not exists.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-3-15
 */

class TemplateNotFoundException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setTemplate($template){
		$this->putData('template', $template);
	}
	
	public function getTemplate(){
		return $this->getData('template');
	}
}