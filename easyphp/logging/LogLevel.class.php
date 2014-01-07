<?php

/**
 * This class use to define the log level. it's priority is OFF, FATAL, ERROR, WARN, INFO, DEBUG.
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-17
 */
class LogLevel{
	
	/**
	 * The debug,info, warn, error, fatal log will be record.
	 */
	const DEBUG = 4;
	
	/**
	 * The info, warn, error, fatal log will be record.
	 */
	const INFO = 3;
	
	/**
	 * The warn, error, fatal log will be record.
	 */
	const WARN = 2;
	
	/**
	 * The error, fatal log will be record.
	 */
	const ERROR = 1;
	
	/**
	 * The fatal log will be record.
	 */
	const FATAL = 0;
	
	/**
	 * shutdown all the log
	 */
	const OFF = -1;
	
	/**
	 * judge the level is log level or not.
	 * @access public
	 * @return boolean return true if the level is log level.
	 */
	public static function isLogLevel($level){
		if(in_array($level, array(0,1,2,3,4,5, -1))){
			return true;
		}
		return false;
	}
	
	/**
	 * Get the string name of this level.
	 * @access public
	 * @return string The name of level
	 */
	public static function getLevelName($level){
		switch($level){
			case LogLevel::DEBUG :
				return "DEBUG";
				break;
			case LogLevel::INFO :
				return "INFO";
				break;
			case LogLevel::WARN :
				return "WARN";
				break;
			case LogLevel::ERROR :
				return "ERROR";
				break;
			case LogLevel::FATAL :
				return "FATAL";
				break;
			case LogLevel::OFF :
				return "OFF";
				break;
			default :
				return "UNKOWN";
		}
	}
}