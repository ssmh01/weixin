<?php

/**
 * The event that will be created when match the HttpRequest and ActionMapping.
 * @see <code>Event</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-5
 */
 
class MatchEvent extends Event{
	
	/**
	 * Set up the request that is been matching.
	 * @param HttpRequest $request
	 */
	public function setToMatch(HttpRequest $request){
		$this->setData('toMatch', $request);
	}
	
	/**
	 * Get the request that is been matching.
	 * @return HttpReqeust
	 */
	public function getToMatch(){
		return $this->getData('toMatch');
	}
	
	/**
	 * Set up the ActionMapping that is matchs the request.
	 * @param ActionMapping $mapping
	 */
	public function setBeMatch(ActionMapping $mapping){
		$this->setData('beMatch', $mapping);
	}
	
	/**
	 * Get the ActionMapping that is matchs the request..
	 * @return ActionMapping
	 */
	public function getBeMatch(){
		return $this->getData('beMatch');
	} 
}