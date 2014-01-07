<?php

/**
 * This class use to parse the request tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class request extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script = Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "echo get_request('" . $tag->getName() . "')";
		$script .= Constant::PHP_END_TAG;
		return $script;
	}
}