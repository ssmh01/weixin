<?php

/**
 * This interface represents a matcher to check if the http request matchs the 
 * action or not.
 *
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-24
 */
 
abstract class ActionMatcher{
	
	/**
	 * 模块名,可以为这个匹配器指定默认的模块
	 * @var string
	 */
	private $module;
	
	
	/**
	 * 匹配监听器
	 * @var MatchListener
	 */
	private $listener;
	
	/**
	 * @return the $listener
	 */
	public function getListener() {
		return $this->listener;
	}

	/**
	 * @param MatchListener $listener
	 */
	public function setListener($listener) {
		$this->listener = $listener;
	}
	
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
	 * This method use to find out the Action Class for 
	 * the request you pass in as a parameter.
	 * @param HttpRequest $request
	 * 		The http request.
	 * @param ActionMapping $mapping
	 * 		The action mapping
	 * @return boolean	Return true if match, otherwise return false.
	 */
	public abstract function matchs(HttpRequest $request, ActionMapping $mapping);
}