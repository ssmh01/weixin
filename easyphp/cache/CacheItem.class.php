<?php

/**
 * 代表一个缓存单位
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-04-01
 */
class CacheItem{
	
	/**
	 * 缓存键
	 * @var string
	 */
	private $key;
	
	/**
	 * 缓存内容
	 * @type mixed
	 */
	private $cache;
	
	/**
	 * 缓存时间
	 * @type int
	 */
	private $cacheTime;
	
	/**
	 * 构造一个缓存单位
	 * @param mixed $cache 缓存内容
	 * @param int $cacheTime 缓存时间
	 */
	public function __construct($key, $cache, $cacheTime=null){
		if(!$cacheTime){
			$cacheTime = time();
		}
		$this->setKey($key);
		$this->setCache($cache);
		$this->setCacheTime($cacheTime);
	}
	
	/**
	 * @return the $key
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @param string $key
	 */
	public function setKey($key) {
		$this->key = $key;
	}

	/**
	 * @return the $cache
	 */
	public function getCache() {
		return $this->cache;
	}

	/**
	 * @param mixed $cache
	 */
	public function setCache($cache) {
		$this->cache = $cache;
	}

	/**
	 * @return the $cacheTime
	 */
	public function getCacheTime() {
		return $this->cacheTime;
	}

	/**
	 * @param mixed $cacheTime
	 */
	public function setCacheTime($cacheTime) {
		$this->cacheTime = $cacheTime;
	}
}