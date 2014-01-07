<?php

/**
 * This class use to parse the lang tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-28
 */
class lang extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		//split the tag body.
		$body = $this->splitTagBody($tag);
		if(count($body) > 1){
			$script =  Constant::PHP_START_TAG . Constant::BLANK;
			//has value
			if(!$this->isVariable($body[0])){
				$script .= "echo get_lang(\"{$body[0]}\", {$body[1]})";
			}else{
				$script .= "echo get_lang({$body[0]}, {$body[1]})";
			}
			$script .= Constant::BLANK . Constant::PHP_END_TAG;
			return $script;
		}else{
			if(!$this->isVariable($body[0])){
				//没有PHP变量
				return get_lang("{$body[0]}");
			}else{
				$script =  Constant::PHP_START_TAG . Constant::BLANK;
				$script .= "echo get_lang({$body[0]})";
				$script .= Constant::BLANK . Constant::PHP_END_TAG;
				return $script;
			}
		}
	}
}