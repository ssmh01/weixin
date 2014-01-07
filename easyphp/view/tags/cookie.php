<?php

/**
 * This class use to parse the cookie tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class cookie extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script = Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "echo get_cookie('" . $tag->getName() . "')";
		$script .= Constant::PHP_END_TAG;
		return $script;
	}
}