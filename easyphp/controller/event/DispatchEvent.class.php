<?php

/**
 * The event that will be created when controller dispatch the request.
 * @see <code>Event</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-5
 */
 
class DispatchEvent extends Event{
	
	function __construct(HttpRequest $source){
		parent::__construct($source);
		$this->setFrom($source);
	}
	
	/**
	 * Set up the request that is been dispatching.
	 * @param HttpRequest $request
	 */
	public function setFrom(HttpRequest $request){
		$this->setData('from', $request);
	}
	
	/**
	 * Get the request that is been dispatching.
	 * @return HttpReqeust
	 */
	public function getFrom(){
		return $this->getData('from');
	}
	
	/**
	 * Set up the action that is been use to processing the request.
	 * @param Action $action
	 */
	public function setTo(Action $action){
		$this->setData('to', $action);
	}
	
	/**
	 * Get the action that is been use to processing the request.
	 * @return Action
	 */
	public function getTo(){
		return $this->getData('action');
	} 
}