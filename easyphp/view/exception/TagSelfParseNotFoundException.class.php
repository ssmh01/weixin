<?php

/**
 * This Object represents a Exception to tell users that the TagSelfParse is
 * not found for the tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-3-15
 */

class TagSelfParseNotFoundException extends EasyException{
	
	function __construct($message){
		parent::__construct($message);
	}
	
	public function setTag($tag){
		$this->putData('tag', $tag);
	}
	
	public function getTag(){
		return $this->getData('tag');
	}
}