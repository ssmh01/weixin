<?php

abstract class AbstractCacheDriver implements CacheDriver{

	/**
	 * 缓存配置
	 * @type <code>CacheConfig</code>
	 */
	private $cacheConfig = null;
	
	/**
	 * @return the $cacheConfig
	 */
	public function getCacheConfig() {
		return $this->cacheConfig;
	}

	/**
	 * @param field_type $cacheConfig
	 */
	public function setCacheConfig($cacheConfig) {
		$this->cacheConfig = $cacheConfig;
	}
}