<?php

/**
 * This class use to parse the config tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class config extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script = Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "echo get_config('" . $tag->getBody() . "')";
		$script .= Constant::PHP_END_TAG;
		return $script;
	}
}