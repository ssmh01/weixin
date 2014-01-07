<?php

/**
 * This class use to parse the run tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class run extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "{$tag->getBody()}";
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
	
	/**
	 * @see TagSelfParse::end()
	 */
	public function end($tag){
		return $tag->toString();
	}
}