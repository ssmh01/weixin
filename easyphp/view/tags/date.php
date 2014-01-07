<?php

/**
 * 用来显示日期
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-03-03
 */
class date extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$params = $this->splitTagBody($tag, 2);
		$format = 'Y-m-d H:i:s';
		//构造参数
		if($params){
			$timestamp = $params[0];
			if($params[1]){
				//指定格式
				$format = $params[1];
			}
		}else{
			$timestamp = 'time()';
		}
		$script =  Constant::PHP_START_TAG . Constant::BLANK;
		if($this->isVariable($format)){
			$script .= "echo date($format, $timestamp)";
		}else{
			$script .= "echo date('{$format}', $timestamp)";
		}
		
		$script .= Constant::PHP_END_TAG;
		return $script;
	}
	
	/**
	 * @see TagSelfParse::end()
	 */
	public function end($tag){
		return $tag->toString();
	}
}