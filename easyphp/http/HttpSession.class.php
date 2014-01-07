<?php

/**
 * This class represent a session manager to support some session operations.
 *
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-23
 */
class HttpSession{
	
	/**
	 * make it can't initialize a object.
	 */
	private function __construct(){}
	
	
	private static $init;
	
	public static function init($init){
		if($init){
			self::$init = $init;
		}
		return self::$init;
	}

	/**
	 * Start session.
	 */
	public static function start(){
		session_start();
	}

	/**
	 * Stop session
	 */
	public static function stop()
	{
		session_write_close();
	}

	/**
	 * clear session and destroy session
	 */
	public static function destroy($clear=true)
	{
		if($clear){
			HttpSession::clear();
		}
		session_destroy();
	}

	/**
	 * Set or get the session id.
	 * @param string $id
	 * @return string
	 */
	public static function id($id = null)
	{
		return isset($id) ? session_id($id) : session_id();
	}

	/**
	 * update the session id of current session.
	 * @param boolean $removeOld
	 */
	public static function updateId($removeOld=false){
		return session_regenerate_id($removeOld);
	}

	/**
	 * set or get the session name.
	 * @param string $name
	 */
	public static function name($name = null)
	{
		return isset($name) ? session_name($name) : session_name();
	}
	
	/**
	 * set or get session cookie path.
	 * @param string $path
	 */
	public static function path($path){
		if(empty($path)) return ini_get('session.cookie_path');
		ini_set('session.cookie_path', $path);
	}
	
	/**
	 * set or get session cookie domain.
	 */
	public static function domain($domain){
		if(empty($domain)) return ini_get('session.cookie_domain');
		ini_set('session.cookie_domain', $domain);
	}

	/**
	 * Get a session value
	 * @param string $name
	 */
	public static function get($name)
	{
		return isset($_SESSION[$name])? $_SESSION[$name] : null;
	}

	/**
	 * Set a session.
	 * @param string $name
	 * @param mixed $value
	 */
	public static function set($name, $value){
		$_SESSION[$name] = $value;
	}

	/**
	 * session name is been set or not.
	 * @param string $name
	 */
	public static function exists($name){
		return isset($_SESSION[$name]);
	}

	/**
	 * remove a session value
	 * @param string $name
	 */
	public static function remove($name){
		unset($_SESSION[$name]);
	}

	/**
	 * clear all session
	 */
	public static function clear()
	{
		session_unset();
		$_SESSION = array();
	}
	
	/**
	 * Set or get the session save path.
	 * @param string $path
	 */
	public static function savePath($path=null)
	{
		return !empty($path)? session_save_path($path) : session_save_path();
	}

	/**
	 * get the session save file's name.
	 */
	public static function getSessionFile(){
		return HttpSession::savePath() . '/' . 'sess_' . HttpSession::id();
	}

	/**
	 * set or get use cookie value.
	 * @param any $useCookies
	 */
	public static function useCookies($useCookies=null)
	{
		if(!isset($useCookies)) return ini_get('session.use_cookies') ? true : false;
		return ini_set('session.use_cookies', $useCookies ? 1 : 0);
	}

	/**
	 * set or the lifetime of sessionid cookie. 
	 * @param int $lifetime
	 */
	public static function cookieLifetime($lifetime){
		if(!isset($lifetime)) return ini_get('session.cookie_lifetime');
		return ini_set('session.cookie_lifetime', $lifetime);
	}

	/**
	 * set or get session.gc_maxlifetime
	 * @param int $gcMaxLifetime
	 */
	public static function gcMaxLifetime($gcMaxLifetime=null)
	{
		if(isset($gcMaxLifetime)) return ini_get('session.gc_maxlifetime');
		return ini_set('session.gc_maxlifetime', $gcMaxLifetime);
	}

	/**
	 * set or get session.gc_probability.
	 * @param int $gcProbability int value between 1 and 100.
	 */
	public static function gcProbability($gcProbability=null)
	{
		if(empty($gcProbability) || !is_int($gcProbability) || $gcProbability < 1){
			$gcProbability = 1;
		}elseif($gcProbability > 100){
			$gcProbability = 100;
		}
		return ini_set('session.gc_probability', $gcProbability);
	}
	
	/**
	 * set or get unserialize_callback_func
	 * @param string $callback
	 */
	public static function unserializeCallback($callback)
	{
		if(empty($callback))	return ini_get('unserialize_callback_func');
		return ini_set('unserialize_callback_func',$callback);
	}

	/**
	 * check the session is expired or not
	 */
	public static function isExpired()
	{
		if (isset($_SESSION['__HTTP_Session_Expire_TS']) && $_SESSION['__HTTP_Session_Expire_TS'] < time()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * set the session expire time
	 * @param int $time
	 * @param boolean $add
	 */
	public static function setExpire($time, $add=false)
	{
		if ($add) {
			if (!isset($_SESSION['__HTTP_Session_Expire_TS'])) {
				$_SESSION['__HTTP_Session_Expire_TS'] = time() + $time;
			}
			$oldGcMaxLifetime = HttpSession::gcMaxLifetime();
			HttpSession::gcMaxLifetime($oldGcMaxLifetime + $time);
		} elseif (!isset($_SESSION['__HTTP_Session_Expire_TS'])) {
			$_SESSION['__HTTP_Session_Expire_TS'] = $time;
		}
	}

	/**
	 * get session expire time
	 */
	public static function getExpire(){
		if($_SESSION['__HTTP_Session_Expire_TS']) return $_SESSION['__HTTP_Session_Expire_TS'];
		return HttpSession::gcMaxLifetime();
	}
}

/**
 * Make class name shorter.
 */
class HS extends HttpSession{}