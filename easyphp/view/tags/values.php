<?php

/**
 * This class use to parse the value tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-19
 */
class values extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		if($this->isVariable($tag->getName())){
			return Constant::PHP_START_TAG . Constant::BLANK . 'echo ' . $tag->getName() . Constant::PHP_LINE_SEPARATOR . Constant::BLANK . Constant::PHP_END_TAG;
		}else{
			return $tag->toString();
		}
	}
	
	/**
	 * @see TagSelfParse::end()
	 */
	public function end($tag){
		
	}
}