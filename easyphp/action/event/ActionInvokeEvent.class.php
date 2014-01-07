<?php

/**
 * Action方法调用事件
 * @see <code>Event</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-03-06
 */
 
class ActionInvokeEvent extends Event{
	
	/**
	 * 当前被调用的Action
	 * @param Action $action
	 */
	public function setAction($action){
		$this->setData('action', $action);
	}
	
	public function getAction(){
		return $this->getData('action');
	}
	
	/**
	 * 当前被调用的方法
	 * @param string $method
	 */
	public function setMethod($method){
		$this->setData('method', $method);
	}
	
	public function getMethod(){
		return $this->getData('method');
	}
}