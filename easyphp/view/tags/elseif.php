<?php

/**
 * This class use to parse the elseif tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class testelse extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		if($tag->getBody()){
			$script .= "}elseif({$tag->getBody()}){";
		}else{
			$script .= "}else{";
		}
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
	
	/**
	 * @see TagSelfParse::end()
	 */
	public function end($tag){
		return '';
	}
}