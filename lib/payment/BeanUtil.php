<?php

/**
 * This class is a tool class use to service for beans
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-17
 */
class BeanUtil{
	
	/**
	 * Create a object instance.
	 * @param string $class
	 */
	public static function builtInstance($clazz){
		if(!is_string($clazz)){
			return $clazz;
		}
		$refClass = new ReflectionClass($clazz);
		$obj = $refClass->newInstance();
		return $obj;
	}
	
	/**
	 * Set up the property for the bean.
	 * @param $clazz 
	 * 	String or Object type, if it is String, We will use this string to create a object.
	 * @param Array params 
	 * 	This is a property array, it contains the propery names and values which
	 *  you want to set to the object.
	 * @return Any object which had been set up.
	 */
	public static function install($clazz, Array $params){
		if(is_string($clazz)){
			$refClass =new ReflectionClass($clazz);
			$obj = $refClass->newInstance();
		}else{
			// is object
			$obj = $clazz;
			$refClass =new ReflectionClass($obj);
		}
		$methodName = NULL;
		$method = NULL;
		foreach($params as $key => $value){
			$methodName = "set" . ucwords($key);
			if($refClass->hasMethod($methodName)){
				$method = $refClass->getMethod($methodName);
				$method->invoke($obj, $params[$key]);
			}
		}
		return $obj;
	}
	
	/**
	 * Copy the attributs from a bean and set them to anthor bean.
	 * @access public
	 * @param stdclass $beanTo	The bean which want to setting attribute.
	 * @param stdclass $beanFrom The bean which use to be copy attributes.
	 */
	public static function attributeCopys($beanTo, $beanFrom){
		die('attributeCopys is not support yet!');
	}
}