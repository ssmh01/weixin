<?php
/**
 * This is a tool class use to process the String.
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-17
 */
class String{
	
	const REGEX_EMAIL = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
	const REGEX_URL = '/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/';
	const REGEX_CURRENCY = '/^\d+(\.\d+)?$/';
	const REGEX_NUMBER = '/^\d+$/';
	const REGEX_ZIP = '/^[1-9]\d{5}$/';
	const REGEX_INTEGER = '/^[-\+]?\d+$/';
	const REGEX_DOUBLE = '/^[-\+]?\d+(\.\d+)?$/';
	const REGEX_ENGLISH = '/^[A-Za-z]+$/';
	const REGEX_MOBILE = '/^1[0-9]{2}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/';
	
	/**
	 * The string is end with some letter or not.
	 * @param String $string	The string you want to test.
	 * @param String $end	The end string you want to test.
	 * @param boolean $sensitive	Case sensitive, default is false.
	 * @return boolean Return true if the $string end with $end, otherwise false.
	 */
	public static function endWith($string, $end, $sensitive=false){
		$pattern = $sensitive? '/.*' . preg_quote($end) . '$/' : '/.*' . preg_quote($end) . '$/i';
		if(preg_match($pattern, $string)){
			return true;
		}
		return false;
	}
	
	/**
	 * The string is start with some letter or not.
	 * @param String $string	The string you want to test.
	 * @param String $start	The start string you want to test.
	 * @param boolean $sensitive	Case sensitive, default is false.
	 * @return boolean Return true if the $string start with $start, otherwise false.
	 */
	public static function startWith($string, $start, $sensitive=false){
		$pattern = $sensitive? '/^' . preg_quote($start) . '.*/' : '/^' . preg_quote($start) . '.*/i';
		if(preg_match($pattern, $string)){
			return true;
		}
		return false;
	}
	
	/**
	 * 
	 * @param string $string
	 * @param string $splitChar
	 */
	public static function cutFromFirst($string, $splitChar){
		$firstIndex = strpos($string, $splitChar);
		if($firstIndex === false) return $string;
		return substr($string, 0, $firstIndex);
	}
	
	/**
	 * 
	 * @param string $string
	 * @param string $splitChar
	 */
	public static function cutFromLast($string, $splitChar){
		$lastIndex = strrpos($string, $splitChar);
		if($lastIndex === false) return $string;
		return substr($string, 0, $lastIndex);
	}
	
	/**
	 * 
	 * @param string $fileName
	 * @param string $suffix
	 */
	public static function getFileNameWithoutSuffix($fileName, $suffix){
		if(empty($fileName)) return;
		if(empty($suffix)){
			$suffix = '.';
			return String::cutFromLast($fileName, $suffix);
		}else{
			if(!String::endWith($fileName, $suffix)) return $fileName;
			return String::cutFromLast($fileName, $suffix);
		}
	}
	
	public static function lower($string){
		return $string == strtolower($string);
	}
	
	/**
	 * 第一个字母小写
	 * @param string $string
	 */
	public static function firstLower($string){
		if(function_exists('lcfirst')){
			//PHP5.3才支持lcfirst
			return lcfirst($string);
		}
		$string[0] = String::lower($string[0]);
		return $string;
	}
	
	public static function upper($string){
		return $string == strtoupper($string);
	}
	
	public static function firstUpper($string){
		return ucfirst($string);
	}
	
	public static function isLower($string){
		return $string == strtolower($string);
	}
	
	public static function isUpper($string){
		return $string == strtoupper($string);
	}
	
	/**
	 * 正则测试
	 * @param string $regex 正则表达式
	 * @param string $string 被测试的字串串
	 */
	public static function test($regex, $string){
		return preg_match($regex, $string) === 1;
	}
}