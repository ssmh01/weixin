<?php

/**
 * This class use to parse the loop tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
class loop extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		//split the tag body.
		$body = preg_split("/[\s]+/", $tag->getBody(), -1, PREG_SPLIT_NO_EMPTY);
		if(count($body) >= 3){
			//has index key
			$script .= "foreach({$body[0]} as {$body[1]}=>{$body[2]}){";
		}else{
			$script .= "foreach({$body[0]} as {$body[1]}){";
		}
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
}