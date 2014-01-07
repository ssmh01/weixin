<?php

/**
 * This Object reprenets as a controller invoker and add event support to the controller.
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-5
 */
 
class Dispatcher{
	
	/**
	 * The listener to processing the dispatch event.
	 * @type <code>DispatchListenner</code>
	 */
	private $listener;
	
	/**
	 * The controller instance.
	 * @type <code>ControllerInterface</code>
	 */
	private $controller;
	
	function __construct($controller){
		if($controller && $controller instanceof ControllerInterface){
			$this->setController($controller);
		}
	}
	
	/**
	 * Get the controller
	 */
	public function getController(){
		return $this->controller;
	}
	
	/**
	 * set up the controller
	 */
	public function setController(Controller $controller){
		$this->controller = $controller;
	}
	
	/**
	 * @return the $listener
	 */
	public function getListener() {
		return $this->listener;
	}

	/**
	 * @param DispatchListenner $listener
	 */
	public function setListener($listener) {
		$this->listener = $listener;
	}

	/**
	 * Distribute the http request which come from client. 分发来自客户端的HTTP请求
	 * @param HttpRequest $request	This parameter can not be NULL.
	 * @return <code>Action</code> description
	 */
	public function dispatch(HttpRequest $request){
		$action = null;
		if($this->listener){
			$event = new DispatchEvent($request);
			$a = $this->listener->beforeDispatch($event); //监听器beforeDispatch方法
			if($a && $a instanceof Action){
				$action = $a;
			}
		}
		if(!$action){
			$action = $this->controller->requestDispatch($request); //请求分发
		}
		if($this->listener){
			!$action or $event->setTo($action);
			$a = $this->listener->afterDispatch($event);
			if($a && $a instanceof Action){
				$action = $a;
			}
		}
		if(!$action){
			$e = new ActionNotFoundException("action not found for uri: " . $request->getRequestURI());
			$e->setRequestURI($request->getRequestURI());
			throw $e;
		}
		return $action;
	}
}