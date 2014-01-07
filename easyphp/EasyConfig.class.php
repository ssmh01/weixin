<?php

/**
 * The runtime config of mvc framework,it use a array to store the config item.
 * You can use <code>getConfig($name)</code> to get the config value.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-20
 */
class EasyConfig{
	
	private $configs;
	
	/**
	 * To construct a EasyConfig Instance.
	 * @param array $configs A array contains config items.
	 */
	public function __construct($configs){
		if(is_array($configs)){
			$this->configs = $configs;
		}else{
			$this->configs = array();
		}
		//the root path of framework
		$this->addConfig('base_root', rtrim(dirname(__FILE__), '/') . '/');
	}
	

	/**
	 * Set the configs.
	 * @param array $configs
	 */
	public function setConfigs(Array $configs){
		$this->configs = $configs;
	}
	
	/**
	 * Add some config item into the configs
	 * @param array $configs
	 */
	public function addConfigs(Array $configs){
		$this->configs = array_merge($this->configs, $configs);
	}
	
	/**
	 * Set a config item.
	 * @param string $name	The name of config.
	 * @param any $value	The value of config.
	 */
	public function addConfig($name, $value){
		$this->configs[$name] = $value;		
	}
	
	/**
	 * Remove a config item.
	 * @param string the name of config.
	 */
	public function removeConfig($name){
		unset($this->configs[$name]);
	}
	
	/**
	 * Get the configs
	 * @return array the runtime configs of framework.
	 */
	public function getConfigs(){
		return $this->configs;
	}
	
	/**
	 * Set a config.
	 * @param array $configs
	 */
	public function setConfig($key, $value){
		$this->configs[$key] = $value;
	}
	
	/**
	 * Get a config value.
	 * @return any the value of config, NULL if the config item is not exsits.
	 */
	public function getConfig($name){
		return $this->configs[$name];		
	}
	
	public function clearConfigs(){
		unset($this->configs);
		$this->configs = array();
	}
	
	//Following functions is make the get config operation more comfortable.
	
	/**
	 * 对方法进行适配
	 * @param string $method 方法名
	 * @param array $args 参数
	 */
	public function __call($method, $args){
		if(String::startWith($method, 'get')){
			$toGet = String::firstLower(String::cutFromFirst($method, 'get'));
			return $this->$toGet;
		}elseif(String::startWith($method, 'set')){
			$toSet = String::firstLower(String::cutFromFirst($method, 'set'));
			$this->$toSet = $args[0];
		}
	}
	
	/** 
	 * @see SetGetAdapter::__set()
	 */
	public function __set($name, $value) {
		$this->configs[$name] = $value;
	}

	/**
	 * @see SetGetAdapter::__get()
	 */
	public function __get($name) {
		return $this->configs[$name];
	}
	
}