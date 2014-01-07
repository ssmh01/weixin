<?php

/**
 * 模块类,代表一个模块
 * @author blueyb.java@gmail.com
 * @since 1.0 - Feb 15, 2012
 */

class Module extends AttributeSupport{
	
	/**
	 * 模块名称，唯一
	 * @var string
	 */
	private $name;
	
	/**
	 * 模块配置
	 * @var EasyConfig
	 */
	private $config;
	
	public function __construct($name){
		$this->setName($name);
	}
	
 	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return the $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param EasyConfig $config
	 */
	public function setConfig($config) {
		$this->config = $config;
	}
}