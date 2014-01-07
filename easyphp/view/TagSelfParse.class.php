<?php

/**
 * This class represent a tag parser to parse itself.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-19
 */
abstract class TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * parse the start tag
	 * @param Tag $tag
	 * @return return the parse content
	 */
	public abstract function start($tag);
	
	/**
	 * parse the eng tag.
	 * @param Tag $tag
	 * @return return the parse content
	 */
	public function end($tag){
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "}";
		$script .= Constant::BLANK . Constant::PHP_END_TAG;
		return $script;
	}
	
	/**
	 * split the tag body
	 * @param Tag $tag
	 * @return array
	 */
	protected function splitTagBody($tag, $limit=-1){
		return preg_split("/[\s]+/", $tag->getBody(), $limit, PREG_SPLIT_NO_EMPTY);
	}
	
	/**
	 * 解析标签参数
	 * @param Tag $tag
	 */
	protected function parseTagParams($tag){
		$bodys = $this->splitTagBody($tag);
		$params = array();
		$param = array();
		foreach($bodys as $body){
			$param = explode('=', $body);
			if(count($param) ==2 && $param[0]){
				$params[$param[0]] = $param[1];
			}
		}
		return $params;
	}
	
	/**
	 * 判断一串字符串是否是变量格式
	 * @param string $str
	 */
	protected function isVariable($str){
		if(preg_match('/\$[_a-zA-Z][A-Za-z0-9_]*/', $str)) {
			return true;
		}
		return false;
	}
}