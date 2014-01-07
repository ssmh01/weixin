<?php

/**
 * 缓存包装类
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-04-01
 */
class Cache{
	
	///////////////////////////////////////////Cache Type/////////////////////////////////////
	
	const TYPE_MEMCACHE = 'memcache';
	
	const TYPE_APC = 'apc';
	
	const TYPE_EACCELERATOR = 'eaccelerator';
	
	const TYPE_XCACHE = 'xcache';
	
	const TYPE_DISK = 'disk';
	
	//////////////////////////////////////////Cache Info/////////////////////////////////////
	
	const INFO_CACHE_LIFE_TIME = 10;
	
	const INFO_CACHE_CACHE_TIME = 11;
	
	const INFO_CACHE_EXPIRED_TIME = 12;
	
	//////////////////////////////////////Cache Time Const///////////////////////////////////////
	
	const CACHE_TIME_NERVER_EXPIRED = 0;
	
	const CACHE_TIME_MINUTE_HALF = 30;
	
	const CACHE_TIME_MINUTE_ONE = 60;
	
	const CACHE_TIME_MINUTE_TEN = 600; 
	
	const CACHE_TIME_HOUR_HALF = 1800;
	
	const CACHE_TIME_HOUR_ONE = 3600;
	
	const CACHE_TIME_DAY_HALF = 43200;
	
	const CACHE_TIME_DAY_ONE = 86400;
	
	const CACHE_TIME_WEEK_ONE = 604800;
	
	const CACHE_TIME_MONTH_ONE = 2592000;
	
	const CACHE_TIME_YEAR_ONE = 31536000;
	
	/**
	 * 缓存驱动
	 * @type CacheDriver
	 */
	private $cacheDriver = null;
	
	/**
	 * 缓存配置
	 * @type <code>CacheConfig</code>
	 */
	private $cacheConfig = null;
	
	/**
	 * 初始化缓存器
	 * @param CacheConfig $cacheConfig
	 */
	function __construct($cacheConfig){
		$this->cacheConfig = $cacheConfig;
		$cacheDriverName = $cacheConfig->getCacheDriver();
		if($cacheDriverName){
			$this->cacheDriver = BeanUtils::builtInstance($cacheDriverName, array('cacheConfig'=>$cacheConfig));
			$this->cacheDriver->init();
		}
	}

	/**
	 * @return the $cacheConfig
	 */
	public function getCacheConfig() {
		return $this->cacheConfig;
	}

	/**
	 * @param CacheConfig $cacheConfig
	 */
	public function setCacheConfig($cacheConfig) {
		$this->cacheConfig = $cacheConfig;
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
	protected function setCacheDriver($cacheDriver) {
		$this->cacheDriver = $cacheDriver;
	}

	/**
	 * 添加一个缓存
	 * @param string $key 缓存键
	 * @param mixed $value　缓存内容
	 * @return boolean true/false
	 */
	public function addCache($key, $value) {
		$cacheItem = new CacheItem($key,$value);
		return $this->cacheDriver->addCache($cacheItem);
	}
	
	/**
	 * 更新一个缓存对象
	 * @param string $key
	 * @param mixed $value,如果不指定这个参数，则使用自动更新函数更新缓存
	 * @return mixed 返回更新的缓存或空
	 * @return boolean true/false
	 */
	public function updateCache($key, $value=null){
		if(!$value){
			$cacheDataSourceClassName = $this->cacheConfig->getCacheDataSourceClass();
			//没有缓存更新数据源类
			if(!$cacheDataSourceClassName) return null;
			try{
				$cacheUpdateMethodName = $this->getCacheUpdateMethodName($key);
				$cacheDataSourceClass = new ReflectionClass($cacheDataSourceClassName);
				
				//没有缓存更新函数
				if(!$cacheDataSourceClass->hasMethod($cacheUpdateMethodName)) return null;
				$method = $cacheDataSourceClass->getMethod($cacheUpdateMethodName);
				$params = $this->cacheConfig->getCacheInfo($key, CacheConfig::INFO_DATA_SOURCE_METHOD_PARAMS);
				if(is_array($params)){
					$value = $method->invokeArgs($cacheDataSourceClass->newInstance(), $params);
				}else{
					$value = $method->invoke($cacheDataSourceClass->newInstance(), $params);
				}
			}catch(Exception $e){
				$cacheException = new CacheException($e->getMessage());
				throw $cacheException;
			}
		}
		$cacheItem = new CacheItem($key,$value);
		return $this->cacheDriver->updateCache($cacheItem);
	}

	/**
	 * 删除一个缓存
	 * @param string $key 缓存键
	 */
	public function removeCache($key) {
		return $this->cacheDriver->removeCache($key);
	}

	/**
	 * @see CacheDriver::getCache()
	 * @throws CacheException
	 */
	public function getCache($key) {
		$cacheItem = $this->cacheDriver->getCache($key);
		//如果存在缓存并且没有过期则直接返回
		if($cacheItem && !$this->isExpired($cacheItem)) return $cacheItem->getCache();
		
		/**下面代码是不存在或者过期的处理代码*/
		
		$cacheDataSourceClassName = $this->cacheConfig->getCacheDataSourceClass();

		if(!$cacheDataSourceClassName) {
			//没有缓存更新数据源类
			if(!$cacheItem) return null;
			if($this->cacheConfig->isDeleteExpiredCache()){
				//删除过期
				$this->removeCache($key);
				return null;
			}else{
				return $cacheItem->getCache();
			}
		}
		//过期的缓存
		$cacheUpdateMethodName = $this->getCacheUpdateMethodName($key);
		try{
			$cacheDataSourceClass = new ReflectionClass($cacheDataSourceClassName);
			if($cacheDataSourceClass->hasMethod($cacheUpdateMethodName)){
				//有缓存更新函数
				$method = $cacheDataSourceClass->getMethod($cacheUpdateMethodName);
				
				$params = $this->cacheConfig->getCacheInfo($key, CacheConfig::INFO_DATA_SOURCE_METHOD_PARAMS);
				if(is_array($params)){
					$cache = $method->invokeArgs($cacheDataSourceClass->newInstance(), $params);
				}else{
					$cache = $method->invoke($cacheDataSourceClass->newInstance(), $params);
				}
				//更新缓存
				$this->updateCache($key, $cache);
				return $cache;
			}else{
				//没有缓存更新函数
				if(!$cacheItem) return null;
				if($this->cacheConfig->isDeleteExpiredCache()){
					//删除过期
					$this->removeCache($key);
					return null;
				}else{
					return $cacheItem->getCache();
				}
			}
		}catch(Exception $e){
			$cacheException = new CacheException($e->getMessage());
			throw $cacheException;
		}
		return null;
	}

	/**
	 * @see CacheDriver::getCacheInfo()
	 */
	public function getCacheInfo($key, $infoType) {
		switch ($infoType){
			case Cache::INFO_CACHE_LIFE_TIME:
				$cacheInfo = $this->cacheConfig->getCacheInfo($key);
				return isset($cacheInfo['lifetime'])?$cacheInfo['lifetime']:$this->cacheConfig->getLifeTime();
				break;
			case Cache::INFO_CACHE_CACHE_TIME:
				$cacheItem = $this->cacheDriver->getCache($key);
				if(empty($cacheItem)){
					return null;
				}
				return $cacheItem->getCacheTime();
				break;
			case Cache::INFO_CACHE_EXPIRED_TIME:
				$lifetime = $this->getCacheInfo($key, Cache::INFO_CACHE_LIFE_TIME);
				if($lifetime == Cache::CACHE_TIME_NERVER_EXPIRED){
					return Cache::CACHE_TIME_NERVER_EXPIRED;
				}
				$cacheTime = $this->getCacheInfo($key, Cache::INFO_CACHE_CACHE_TIME);
				if(!$cacheTime) return null;
				return $cacheTime + $lifetime;
				break;
			default:
				return null;
		}
		return null;
	}

	/**
	 * @see CacheDriver::getEnvInfo()
	 */
	public function getEnvInfo($infoType) {
		return $this->cacheDriver->getEnvInfo($infoType);
	}
	
	/**
	 * @see CacheDriver::clear()
	 */
	public function clear() {
		$this->cacheDriver->clear();
	}

	/**
	 * @see CacheDriver::destory()
	 */
	public function destory() {
		return $this->cacheDriver->destory();
	}
	
	/**
	 * 检查缓存是否过期
	 * @param CacheItem/string $cache
	 * @return ture/false
	 */
	public function isExpired($cache){
		if(is_string($cache)){
			$expiredTime = $this->getCacheInfo($key, Cache::INFO_CACHE_EXPIRED_TIME);
			if(!$expiredTime || $expiredTime == Cache::CACHE_TIME_NERVER_EXPIRED){
				//如果过期时间为空或为永不过期
				return false;
			}
		}else{
			$lifetime = $this->cacheConfig->getCacheInfo($cache->getKey(), CacheConfig::INFO_CACHE_LIFE_TIME);
			//永不过期
			if($lifetime == Cache::CACHE_TIME_NERVER_EXPIRED) return false;
			$expiredTime = $lifetime + $cache->getCacheTime();
		}
		$expired = (time() > $expiredTime);
		if($expired){
			return true;
		}else{
			return false;
		}
	}
	
	private function isCacheDriver($cacheDriver){
		if($cacheDriver instanceof CacheDriver){
			return true;
		}
		return false;
	}
	
	private function getCacheUpdateMethodName($key){
		$cacheUpdateMethodName = $this->cacheConfig->getCacheInfo($key, CacheConfig::CACHE_DATA_SOURCE_METHOD_NAME);
		if(!$cacheUpdateMethodName){
			//没有指定了更新方法名，使用默认的更新方法名
			$cacheUpdateMethodName = $key;
		}
		return $cacheUpdateMethodName;
	}
}