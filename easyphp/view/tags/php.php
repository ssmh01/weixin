<?php

/**
 * This class use to parse the php tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class php extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		return Constant::PHP_START_TAG;
	}
	
	/**
	 * @see TagSelfParse::end()
	 */
	public function end($tag){
		return Constant::PHP_END_TAG;
	}
}