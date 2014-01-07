<?php

/**
 * This class use to parse the if tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class testif extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "if({$tag->getBody()}){";
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
}