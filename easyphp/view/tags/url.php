<?php

/**
 * This class use to parse the url tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-02-23
 */
class url extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$url = $tag->getBody();
		if(!$this->isVariable($url)){
			//URL没有中没有PHP变量
			return url($url);
		}
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$url = str_replace(array('\[', '\]'), array('{','}'), $url);
		if($url[0] == '"' || $url[0] == "'"){
			//以"或'开头
			$script .= "echo url({$url})";
		}else{
			$script .= "echo url(\"{$url}\")";
		}
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
}