<?php
/**
 * 
 * This class represent a config to use cache functions.
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-04-20
 */
class CacheConfig{
	
	/**
	 * 缓存生命周期配置项名
	 * @var string
	 */
	const CACHE_LIFE_TIME_NAME = 'lifetime';
	
	/**
	 * 缓存数据更新方法配置项名
	 * @var string
	 */
	const CACHE_DATA_SOURCE_METHOD_NAME = 'method';
	
	/**
	 * 缓存数据更新方法参数配置项名
	 * @var string
	 */
	const CACHE_DATA_SOURCE_METHOD_PARAMS = 'params';
	
	/**
	 * 缓存信息类型[缓存生命周期]
	 * @var string
	 */
	const INFO_CACHE_LIFE_TIME = self::CACHE_LIFE_TIME_NAME;
	
	/**
	 * 缓存信息类型[缓存数据更新方法]
	 * @var string
	 */
	const INFO_CACHE_DATA_SOURCE_METHOD = self::CACHE_DATA_SOURCE_METHOD_NAME;
	/**
	 * 缓存信息类型[ 缓存数据更新方法参数]
	 * @var string
	 */
	const INFO_DATA_SOURCE_METHOD_PARAMS = self::CACHE_DATA_SOURCE_METHOD_PARAMS;
	
	/**
	 * global lifetime of cache entry, priority is low.
	 * @type int
	 */
	private $lifetime;
	
	/**
	 * The CacheDriver to cache.
	 * @type CacheDriver
	 */
	private $cacheDriver;
	
	
	/**
	 * 缓存数据源类
	 * @var string
	 */
	private $cacheDataSourceClass;
	
	/**
	 *当没有缓存更新接口时是否删除过期的缓存，如果删除，缓存获取接口将返回null，如果不删除则返回过期的缓存
	 *@var boolean
	 */
	private $deleteExpiredCache;
	
	/**
	 * 缓存配置
	 */
	private $configs;
	
	/**
	 * 缓存表
	 * @var array
	 */
	private $cacheMap;
	
	/**
	 * 获取一项配置
	 * @param string $key
	 */
	public function getConfig($key){
		return $this->configs[$key];
	}
	
	/**
	 * @return the $configs
	 */
	public function getConfigs() {
		return $this->configs;
	}

	/**
	 * @param field_type $configs
	 */
	public function setConfigs($configs) {
		$this->configs = $configs;
	}

	/**
	 * @return the $lifetime
	 */
	public function getLifetime() {
		return $this->lifetime;
	}

	/**
	 * @param int $lifetime
	 */
	public function setLifetime($lifetime) {
		$this->lifetime = $lifetime;
	}

	/**
	 * @return the $cacheDriver
	 */
	public function getCacheDriver() {
		return $this->cacheDriver;
	}

	/**
	 * @param CacheDriver $cacheDriver
	 */
	public function setCacheDriver($cacheDriver) {
		$this->cacheDriver = $cacheDriver;
	}

	/**
	 * @return the $deleteExpiredCache
	 */
	public function isDeleteExpiredCache() {
		return $this->deleteExpiredCache;
	}

	/**
	 * @param boolean $deleteExpiredCache
	 */
	public function setDeleteExpiredCache($deleteExpiredCache) {
		$this->deleteExpiredCache = $deleteExpiredCache;
	}
	
	/**
	 * @return the $cacheMap
	 */
	public function getCacheMap() {
		return $this->cacheMap;
	}

	/**
	 * @param array $cacheMap
	 */
	public function setCacheMap($cacheMap) {
		$this->cacheMap = $cacheMap;
	}

	/**
	 * @return the $cacheDataSourceClass
	 */
	public function getCacheDataSourceClass() {
		return $this->cacheDataSourceClass;
	}

	/**
	 * @param string $cacheDataSourceClass
	 */
	public function setCacheDataSourceClass($cacheDataSourceClass) {
		$this->cacheDataSourceClass = $cacheDataSourceClass;
	}

	/**
	 * 获取缓存信息
	 * @param string $key 缓存键名
	 */
	public function getCacheInfo($key, $infoType=null){
		if($infoType){
			return $this->cacheMap[$key][$infoType];
		}
		return $this->cacheMap[$key];
	}
}
