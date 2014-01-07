<?php

/**
 * This Class is a swrap class to use the php redis function.
 * If you want to use this class, you must setup the redis 
 * moudel for php environment.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-03-28
 */
class RedisCacheDriver extends AbstractCacheDriver{
	
	/**
	 * Memcache对象引用.
	 * @var Memcache
	 */
	private $rediska = null;
	
	public function init(){
		require_once(EXT_LIB_ROOT . 'rediska/Rediska.php');
		if(!class_exists('Rediska')){
			throw new CacheException("你的服务器不支持Redis缓存! 请先导入Rediska库!");
		}
		$redisConfigs = $this->getCacheConfig()->getConfig('redis');
		if(empty($redisConfigs)){
			throw new CacheException("要使用Redis缓存, 请先配置Redis!");
		}
		$this->rediska = new Rediska($redisConfigs);
	}
	
	/**
	 * @see CacheDriver::addCache()
	 */
	public function addCache(CacheItem $item) {
		$key = new Rediska_Key($item->getKey());
		$key->setValue($item);
	}
	
	/**
	 * @see CacheDriver::updateCache()
	 */
	public function updateCache(CacheItem $item){
		$key = new Rediska_Key($item->getKey());
		$key->setValue($item);
	}

	/*
	 * @see CacheDriver::removeCache()
	 */
	public function removeCache($key) {
		return $this->rediska->delete($key);
	}

	/**
	 * @see CacheDriver::getCache()
	 */
	public function getCache($key) {
		$key = new Rediska_Key($key);
		return $key->getValue($key);
	}
	
	/**
	 * @see CacheDriver::getEnvInfo()
	 */
	public function getEnvInfo($infoType) {
		if(!is_integer($infoType)) return null;
		return null;
	}
	
	/**
	 * @see CacheDriver::clear()
	 */
	public function clear() {
		return $this->rediska->flushDb();
	}

	/**
	 * @see CacheDriver::destory()
	 */
	public function destory() {
		return $this->clear();
	}
}