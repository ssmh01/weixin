<?php

/**
 * 操作对象
 * @author blueyb.java@gmail.com
 */
class Operation{
	
	const JOIN_CODE = '@';
	
	private $module;
	
	private $action;
	
	private $method;
	
	public function __construct($module, $action, $method){
		$this->setMethod($method);
		$this->setAction($action);
		$this->setModule($module);
	}
	/**
	 * @return the $module
	 */
	public function getModule(){
		return $this->module;
	}

	/**
	 * @return the $action
	 */
	public function getAction(){
		return $this->action;
	}

	/**
	 * @return the $method
	 */
	public function getMethod(){
		return $this->method;
	}

	/**
	 * @param field_type $module
	 */
	public function setModule($module){
		$this->module = $module;
	}

	/**
	 * @param field_type $action
	 */
	public function setAction($action){
		$this->action = $action;
	}

	/**
	 * @param field_type $method
	 */
	public function setMethod($method){
		$this->method = $method;
	}

	/**
	 * 生成操作的权限键
	 */
	public function getKey(){
		return $this->getModule() . self::JOIN_CODE . $this->getAction() . self::JOIN_CODE . $this->getMethod();
	}
}

?>