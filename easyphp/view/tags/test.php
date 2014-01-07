<?php

/**
 * This class use to parse the test tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class test extends TagSelfParse{
	
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
	 * @see TagSelfParse::start()
	 */
	public function startIf($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "if({$tag->getBody()}){";
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function startElseif($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "}elseif({$tag->getBody()}){";
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function startElse($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "}else{";
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
}