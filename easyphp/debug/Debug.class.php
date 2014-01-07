<?php
/**
 * This class use to debug the application.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-31
 */
class Debug extends Printer{
	
	/**
	 * Print php ini or set php ini.
	 * @param array/string $keys
	 * @param array/string $values
	 */
	public static function ini($keys, $values){
		if(isset($values)){
			//set ini
			if(is_string($keys)){
				ini_set($keys, $values);
			}elseif(is_array($keys)){
				foreach ($keys as $index => $key){
					self::ini($key, $values[$index]);
				}
			}
		}else{
			//print ini
			if(is_string($keys)){
				self::printKeyValue($keys, ini_get($keys));
			}elseif(is_array($keys)){
				foreach ($keys as $key){
					self::ini($key);
				}
			}
		}
	}
	
	public static function getMicroTime()  
	{  
	    list($usec, $sec) = explode(" ",microtime());  
	    return ((float)$usec + (float)$sec);  
	}
}