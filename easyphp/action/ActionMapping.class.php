<?php

/**
 * This Object represents a mappging of Action. It is use to 
 * record the match result so the framework can use it to create
 * the service action.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-24
 */
class ActionMapping{
	
	/**
	 * 模块名称
	 * @var string
	 */
	private $module;
	
	/**
	 * The Action which provide service for HttpRequest.
	 * @type string
	 */
	private $action;
	
	/**
	 * The method name which you want to invoke for the action.
	 * If it is null, the default method who named "service" will
	 * be invoke.
	 * @type string;
	 */
	private $method = 'index';
	
	/**
	 * The view name which you use to show the action result.
	 * @type string
	 */
	private $view;
	
	/**
	 * The ActionMatcher use to match this ActionMapping.
	 * @type ActionMatcher
	 */
	private $matcher;
	
	/**
	 * @return the $module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * @param string $module
	 */
	public function setModule($module) {
		$this->module = $module;
	}

	/**
	 * Get the action name.
	 * @return string
	 */
	public function getAction(){
		return $this->action;
	}
	
	/**
	 * Set up the action name.
	 * @param string $action
	 */
	public function setAction($action){
		$this->action = $action;
	}
	
	/**
	 * Get the ActionMatcher of this ActionMapping.
	 * @return string The name of ActionMatcher
	 */
	public function getMatcher(){
		return $this->matcher;
	}
	
	/**
	 * Set up the ActionMatcher for this ActionMapping
	 * @param ActionMatcher $matcher
	 */
	public function setMatcher($matcher){
		$this->matcher = $matcher;
	}
	
	/**
	 * Get the action method name.
	 * @return string
	 */
	public function getMethod(){
		return $this->method;
	}
	
	/**
	 * Set up the action method name.
	 * @param string/int $method
	 */
	public function setMethod($method){
		$this->method = $method;
	}
	
	/**
	 * Get the view file name.
	 * @return string
	 */
	public function getView(){
		if(empty($this->view)){
			//如果不设置视图，则返回默认的视图
			$this->view = strtolower($this->getAction() . '_' . $this->getMethod());
		}
		return $this->view;
	}
	
	/**
	 * Set up the view file name.
	 * @param string $view
	 */
	public function setView($view){
		$this->view = $view;
	}
	
	public function toString(){
		return $this->getModule() . '@' . $this->getAction() . '@' . $this->getMethod();
	}
}