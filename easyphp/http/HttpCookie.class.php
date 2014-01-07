<?php

/**
 * This class represent a cookie manager to support some cookie operations.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-23
 */
class HttpCookie{
	
	/**
	 * The prefix of cookie name.
	 */
	private static $prefix;
	
	/**
	 * The lifetime of cookie.
	 */
	private static $lifetime;
	
	/**
	 * The domain of cookie.
	 */
	private static $domain;
	
	/**
	 * The path of cookie.
	 */
	private static $path;
	
	/**
	 * The encode function that been called when set cookie.
	 */
	private static $encode;
	
	/**
	 * The decode function that been called when get cookie.
	 */
	private static $decode;
	
	private static $init;
	
	public static function init($init){
		if($init){
			self::$init = $init;
		}
		return self::$init;
	}
	
	/**
	 * make it can't initialize a object.
	 */
	private function __construct(){}
	
	/**
	 * set or get prefix
	 * @param string $prefix
	 */
	public static function prefix($prefix){
		if(empty($prefix)) return self::$prefix;
		self::$prefix = $prefix;
	}
	
	/**
	 * set or get lifetime
	 * @param string $lifetime
	 */
	public static function lifetime($lifetime){
		if(empty($lifetime)) return self::$lifetime;
		self::$lifetime = $lifetime;
	}
	
	/**
	 * set or get domain
	 * @param string $domain
	 */
	public static function domain($domain){
		if(empty($domain)) return self::$domain;
		self::$domain = $domain;
	}
	
	/**
	 * set or get path
	 * @param string $path
	 */
	public static function path($path){
		if(empty($path)) return self::$path;
		self::$path = $path;
	}
	
	/**
	 * set or get encode
	 * @param string $encode
	 */
	public static function encode($encode){
		if(empty($encode)) return self::$encode;
		self::$encode = $encode;
	}
	
	/**
	 * set or get decode
	 * @param string $decode
	 */
	public static function decode($decode){
		if(empty($decode)) return self::$decode;
		self::$decode = $decode;
	}
	
	/**
	 * Get cookie full name.
	 * @access private
	 * @param string $name
	 */
	private static function getFullName($name){
		return self::$prefix . $name;
	}
	
	/**
	 * Get cookie
	 * @param string $name
	 */
    public static function get($name) {
    	$cookie   = $_COOKIE[HttpCookie::getFullName($name)];
		$decode = empty(self::$decode)? 'base64_decode' : self::$decode;
    	$cookie   =  call_user_func($decode, $cookie);
    	return $cookie;
    }
    
	/**
	 * Set cookie
	 * @param string $name
	 * @param string $value
	 * @param int $lifetime
	 * @param string $path
	 * @param string $domain
	 */
    static function set($name,$value,$lifetime=null,$path=null,$domain=null) {
    	if($lifetime=='') {
    		$lifetime =   self::$lifetime;
    	}
    	$lifetime = empty($lifetime)? 0 : time()+$lifetime;
    	if(!isset($path)) {
    		$path = self::$path;
    	}
    	if(!isset($domain)) {
    		$domain =   self::$domain;
    	}
    	$encode = empty(self::$encode)? 'base64_encode' : self::$encode;
    	$value = call_user_func($encode, $value);
    	setcookie(HttpCookie::getFullName($name), $value, $lifetime, $path, $domain);
    	//to make it useable right now.
    	$_COOKIE[HttpCookie::getFullName($name)] = $value;
    }
	
	/**
	 * Cookie exists or not.
	 * @param string $name
	 * @return boolean
	 */
	public static function exists($name){
		return isset($_COOKIE[HttpCookie::getFullName($name)]);
	}
	
	/**
	 * Remove a cookie
	 * @param string $name
	 */
	public static function remove($name) {
		HttpCookie::set($name,'',time()-3600);
		//to make it useable right now.
		unset($_COOKIE[HttpCookie::getFullName($name)]);
	}

	/**
	 * Clear all cookies.
	 */
	static function clear() {
		unset($_COOKIE);
	}
}

/**
 * Make class name shorter.
 */
class HC extends HttpCookie{}