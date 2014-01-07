<?php

/**
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-3-15
 */

class WritePermissionException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setFileName($file){
		$this->putData('file', $file);
	}
	
	public function getFileName(){
		return $this->getData('file');
	}
}