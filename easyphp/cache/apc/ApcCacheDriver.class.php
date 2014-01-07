<?php

/**
 * This Class is a swrap class to use the php apc cache function.
 * If you want to use this class, you must setup the APC cache 
 * moudel for php environment.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-05-29
 */
class ApcCacheDriver extends AbstractCacheDriver{
	
	private static $TYPE_CACHE_USER = 'user';
	
	public function init(){
		if(!function_exists("apc_fetch")){
			throw new CacheException("你的服务器不支持APC缓存! 请先安将PHP APC模块!");
		}
	}
	
	/**
	 * @see CacheDriver::addCache()
	 */
	public function addCache(CacheItem $item) {
		return apc_store($item->getKey(), $item);
	}
	
	/**
	 * 
	 * @see CacheDriver::updateCache()
	 */
	public function updateCache(CacheItem $item){
		return apc_add($item->getKey(), $item);
	}

	/**
	 * @see CacheDriver::removeCache()
	 */
	public function removeCache($key) {
		return apc_delete($key);
	}

	/**
	 * @see CacheDriver::getCache()
	 */
	public function getCache($key) {
		return apc_fetch($key);
	}
	
	/**
	 * @see CacheDriver::getEnvInfo()
	 */
	public function getEnvInfo($infoType) {
		if(!is_integer($infoType)) return null;
		switch ($infoType){
			case Cache::INFO_ENV_APC_INFO:
				return apc_cache_info();
				break;
			case Cache::INFO_ENV_APC_SMA_INFO:
				return apc_sma_info();
				break;
			default:
				return null;
		}
		return null;
	}
	
	/**
	 * @see CacheDriver::clear()
	 */
	public function clear() {
		return apc_clear_cache(self::$TYPE_CACHE_USER);
	}

	/**
	 * @see CacheDriver::destory()
	 */
	public function destory() {
		return $this->clear();
	}
}