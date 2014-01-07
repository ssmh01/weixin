<?php

/**
 * This Object represents a Exception to tell users that the Action 
 * Matcher is not found.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-20
 */

class ActionMatcherNotFoundException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setActionMatcher($actionMatcher){
		$this->putData('__action_matcher', $actionMatcher);
	}
	
	public function getActionMatcher(){
		return $this->getData('__action_matcher');
	}
}