<?php
/**
 * 系统设置服务
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
class CacheConfigService extends ConfigService implements IConfigService{
	
	protected function __gets($condition = null){
		$cacheName = 'configs';
		$configs = cache_get($cacheName);
		if(empty($configs)){
			$configs = parent::__gets($condition);
			cache_set($cacheName, $configs);
		}
		return $configs;
	}
}