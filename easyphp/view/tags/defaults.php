<?php

/**
 * This class use to parse the default[tagName is null, tagName not found] tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-19
 */
class defaults extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		return $tag->toString();
	}
	
	/**
	 * @see TagSelfParse::end()
	 */
	public function end($tag){
		return $tag->toString();
	}
}