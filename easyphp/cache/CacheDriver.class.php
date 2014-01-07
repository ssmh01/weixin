<?php

/**
 * 缓存驱动类
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-14
 */
interface CacheDriver{
	
	/**
	 * 初始化驱动
	 */
	public function init();

	/**
	 * 添加一个缓存
	 * @param string $key 键
	 * @param CacheItem $item　缓存对象
	 * @return boolean true/false
	 */
	public function addCache(CacheItem $item);
	
	/**
	 * 更新一个缓存
	 * @param string $key 键
	 * @param CacheItem $item　缓存对象
	 * @return boolean true/false
	 */
	public function updateCache(CacheItem $item);
	
	/**
	 * remove a cache entry
	 * @param string $key
	 * @return boolean true/false
	 */
	public function removeCache($key);
	
	/**
	 * Return a cache.
	 * @param string $key
	 * @return mixed
	 */
	public function getCache($key);
	
	/**
	 * get cache environment info such as count of cache entry, memory use and so on.
	 * @param int $infoType
	 */
	public function getEnvInfo($infoType);
	
	/**
	 * remove all cache entries.
	 * @return boolean true/false
	 */
	public function clear();
	
	/**
	 * destory the cache 
	 * @return boolean true/false
	 */
	public function destory();
}