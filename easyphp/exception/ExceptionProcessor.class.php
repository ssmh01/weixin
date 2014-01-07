<?php

/**
 * This class use to process the framework exception.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-21
 */
class ExceptionProcessor{

	/**
	 * An array to map Exception to ExceptionHandler.
	 */	
	private $handlerMap;
	
	public function setHandlerMap($handlerMap){
		$this->handlerMap = $handlerMap;
	}
	
	public function getHandlerMap(){
		return $this->handlerMap;
	}
	
	public function getHandler($exception){
		
	}
	
	public function process(HttpRequest $context, Exception $exception){
		
		$page404 = $context->getConfig()->getConfig('base_404_page');
		if(($exception instanceof ActionNotFoundException || $exception instanceof NoSuchMethodException) && !empty($page404)){
			$context->redirect($page404);
		}
		
		echo('An Exception Happen:<br>'.$exception->getMessage());
		
		if($context->getConfig()->getConfig('debug_enable')){
			die('<pre>'.print_r($exception, true).'</pre>');
		}
	}
}