<?php

/**
 * This class use to parse the param tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-02-23
 */
class param extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "echo \$request->getParameter({$tag->getBody()})";
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
}