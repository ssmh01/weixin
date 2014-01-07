<?php

/**
 * This Class is a swrap class to use the php memcache function.
 * If you want to use this class, you must setup the memcache 
 * moudel for php environment.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-03-28
 */
class MemCacheDriver extends AbstractCacheDriver{
	
	/**
	 * Memcache对象引用.
	 * @var Memcache
	 */
	private $memcache = null;
	
	
	public function init(){
		if(!class_exists('Memcache')){
			throw new CacheException("你的服务器不支持Memcache缓存! 请先安将PHP Memcache模块!");
		}
		$cacheServers = $this->getCacheConfig()->getConfig('memcache_servers');
		if(empty($cacheServers)){
			throw new CacheException("要使用Memcache缓存, 请先配置Memcache!");
		}
		$this->memcache = new Memcache;
		foreach($cacheServers as $cacheServer){
			$host = $cacheServer['host']? $cacheServer['host'] : '127.0.0.1';
			$port = $cacheServer['port']? $cacheServer['port'] : 11211;
			$persistent = $cacheServer['persistent']? $cacheServer['persistent'] : false;
			$weight = $cacheServer['weight']? $cacheServer['weight'] : 0;
			$timeout = $cacheServer['timeout']? $cacheServer['timeout'] : 0;
			$this->memcache->addServer($host, $port, $persistent, $weight, $timeout);
		}
	}
	
	/**
	 * @see CacheDriver::addCache()
	 */
	public function addCache(CacheItem $item) {
		return $this->memcache->set($item->getKey(), $item);
	}
	
	/**
	 * @see CacheDriver::updateCache()
	 */
	public function updateCache(CacheItem $item){
		return $this->memcache->set($item->getKey(), $item);
	}

	/*
	 * @see CacheDriver::removeCache()
	 */
	public function removeCache($key) {
		return $this->memcache->delete($key);
	}

	/**
	 * @see CacheDriver::getCache()
	 */
	public function getCache($key) {
		return $this->memcache->get($key);
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
		return $this->memcache->flush();
	}

	/**
	 * @see CacheDriver::destory()
	 */
	public function destory() {
		return $this->clear();
	}
}