<?php

/**
 * This class is a tool class use to service for beans
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-17
 */
class BeanUtils{
	
	/**
	 * Create a object instance.
	 * @param string $class
	 */
	public static function builtInstance($clazz, $params=null){
		if(!is_string($clazz)){
			return $clazz;
		}
		$clazz = new ReflectionClass($clazz);
		$obj = $clazz->newInstance();
		if($params && is_array($params)){
			BeanUtils::install($obj, $params);
		}
		return $obj;
	}
	
	/**
	 * Set up the property for the bean.
	 * @param $clazz 
	 * 	String or Object type, if it is String, We will use this string to create a object.
	 * @param array params 
	 * 	This is a property array, it contains the propery names and values which
	 *  you want to set to the object.
	 * @return Any object which had been set up.
	 */
	public static function install($clazz, $params){
		if(!$params)return;
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
				try{
					$method->invoke($obj, $params[$key]);
				}catch(Exception $e){
					throw new MethodInvokeException($e->getMessage());
				}
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
		throw new EasyException('attributeCopys is not support yet!');
	}
	
	/**
	 * 检查类是否有指定方法
	 * @param mixed $clazz
	 * @param string $methodName
	 * @return 如果有方法，返回true
	 */
	public static function hasMethod($clazz, $methodName){
		if(! $clazz instanceof ReflectionClass){
			$clazz =new ReflectionClass($clazz);
		}
		return $clazz->hasMethod($methodName);
	}
}