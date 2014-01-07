<?php

/**
 * This Object represents a invoker to invoke the <code>ActionMatcher</code> and
 * provide event support to <code>ActionMatcher</code>.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-01-06
 */
class Matcher{
	
	/**
	 * The listener to processing the match event.
	 * @type <code>MatchListener</code>
	 */
	private $listener;
	
	/**
	 * The ActionMatcher instance.
	 * @type <code>ActionMatcher</code>
	 */
	private $actionMatcher;
	
	/**
	 * Get the ActionMatcher
	 */
	public function getActionMatcher(){
		return $this->actionMatcher;
	}
	
	/**
	 * set up the ActionMatcher
	 */
	public function setActionMatcher(ActionMatcher $actionMatcher){
		if($actionMatcher && $actionMatcher instanceof ActionMatcher){
			$this->actionMatcher = $actionMatcher;
		}
		if($actionMatcher->getListener()){
			$listener = BeanUtils::builtInstance($actionMatcher->getListener());
			$this->setListener($listener);
		}
	}
	
	/**
	 * @return the $listener
	 */
	protected function getListener() {
		return $this->listener;
	}

	/**
	 * @param MatchListener $listener
	 */
	protected function setListener(MatchListener $listener) {
		$this->listener = $listener;
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
	public function matchs(HttpRequest $request, ActionMapping $mapping){
		if($this->listener){
			$event = new MatchEvent($request);
			$this->listener->beforeMatch($event);
		}
		$isMatch = $this->actionMatcher->matchs($request, $mapping);
		if($isMatch && $this->listener){
			$event->setToMatch($request);
			$event->setBeMatch($mapping);
			$this->listener->isMatch($event);
		}
		return $isMatch;
	}
}