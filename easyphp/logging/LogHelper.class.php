<?php

/**
 * This class use to makeing it simple to useing the ${Log} class.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-19
 */
class LogHelper{
	
	private static $log;
	
	public static function setLog(Log $log){
		self::$log = $log;
	}
	
	/**
	 * Log the bebug level message.
	 */
	public static function debug($msgString, $callFile, $callLine){
		if(!LogHelper::isLog(self::$log)) return;
		self::$log->debug($msgString, $callFile, $callLine);
	}
	
	/**
	 * Log the info level message.
	 */
	public static function info($msgString, $callFile, $callLine){
		if(!LogHelper::isLog(self::$log)) return;
		self::$log->info($msgString, $callFile, $callLine);
	}
	
	/**
	 * Log the warn level message.
	 */
	public static function warn($msgString, $callFile, $callLine){
		if(!LogHelper::isLog(self::$log)) return;
		self::$log->warn($msgString, $callFile, $callLine);
	}
	
	/**
	 * Log the error level message.
	 */
	public static function error($msgString, $callFile, $callLine){
		if(!LogHelper::isLog(self::$log)) return;
		self::$log->error($msgString, $callFile, $callLine);
	}
	
	/**
	 * Log the fatal level message.
	 */
	public static function fatal($msgString, $callFile, $callLine){
		if(!LogHelper::isLog(self::$log)) return;
		self::$log->fatal($msgString, $callFile, $callLine);
	}
	
	/**
	 * The $log variable is a ${Log} instance or not.
	 * @return boolean True if is, otherwise false
	 */
	private static function isLog($log){
		if($log instanceof Log) return true;
		return false;
	}
}