<?php

/**
 * This interface represents a service class to providing services 
 * for the http request.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-24
 */

abstract class Action{
	
	/**
	 * The ActionMapping which is match this Action.
	 * @type <code>ActionMapping</code>
	 * 
	 */
	private $actionMapping;
	
	/**
	 * Action所在的模块
	 * @var Module
	 */
	private $module;
	
	/**
	 * This method use to provideing services for the http request.
	 * 
	 * @param HttpRequest $request
	 * 		The http request.
	 */
	public function index(HttpRequest $request){}

	/**
	 * Get the ActionMapping.
	 * @return ActionMapping
	 */
	public function getActionMapping(){
		return $this->actionMapping;
	}
	
	/**
	 * Set up the ActionMapping for this Action
	 * @param ActionMapping $mapping;
	 */
	public function setActionMapping(ActionMapping $mapping){
		$this->actionMapping = $mapping;
	}
	
	/**
	 * @return the $module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * @param Module $module
	 */
	public function setModule(Module $module) {
		$this->module = $module;
	}

	/**
	 * Set up the <code>View</code>.
	 * @param string $view
	 * 	it will be use to create a <code>View</code>.
	 * 	   
	 */
	public function setView($view){
		$this->getActionMapping()->setView($view);
	}

	/**
	 * Get the view of this action.
	 * @return string the view name
	 */
	public function getView(){
		return $this->getActionMapping()->getView();
	}
	
	/**
	 * 向其它模块请求公开的服务
	 * @param string $module 公开服务的模块名
	 * @param string $method 公开服务的接口名
	 * @param mixed $params 传递给服务接口的参数，一个参数直接写，多个参数用数组,顺序和接口声明一致
	 * @return 返回服务接口返回的值
	 * @throws 如果服务不存在，将会抛出服务不存在异常
	 */
	public function requireService($module, $service, $params){
		$moduleServiceReflectionClass = R::getModuleOpenService($module, true);
		if(!$moduleServiceReflectionClass || !$moduleServiceReflectionClass->hasMethod($service)){
			$ex = new ModuleOpenServiceNotFoundException();
			$ex->setModule($module);
			$ex->setService($service);
			throw  $ex;
		}
		$serviceMethod = $moduleServiceReflectionClass->getMethod($service);
		if(is_array($params)){
			return $serviceMethod->invokeArgs($moduleServiceReflectionClass->newInstance(), $params);
		}else{
			return $serviceMethod->invoke($moduleServiceReflectionClass->newInstance(), $params);
		}
	}
}