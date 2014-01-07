<?php

/**
 * Setter和Getter的适配器
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-17
 */
abstract class SetGetAdapter {
	
	/**
	 * 对方法进行适配
	 * @param string $method 方法名
	 * @param array $args 参数
	 */
	public function __call($method, $args){
		if(String::startWith($method, 'get')){
			$toGet = String::firstLower(substr($method, 3));
			return $this->$toGet;
		}elseif(String::startWith($method, 'set')){
			$toSet = String::firstLower(substr($method, 3));
			$this->$toSet = $args[0];
		}
	}
	
	/**
	 * 对静态方法进行适配
	 * @param string $method 方法名
	 * @param array $args 参数
	 */
	public function __callstatic($method, $args){
		$this->__call($method, $args);
	}
	
	/**
	 * 设置数据对象属性
	 * @param string $name 键名
	 * @param string $value	键值
	 */
    public abstract function __set($name,$value);
	
 	/**
     * 获取对象的属性值
     * @param string $name 键名
     */
    public abstract function __get($name) ;
}

?>