<?php

/**
 * 微博服务接口
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-1-7
 */
define('WEIBO_SERVICE_LIB_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
include_once(WEIBO_SERVICE_LIB_PATH . 'WeiboParam.php');
include_once(WEIBO_SERVICE_LIB_PATH . 'WeiboAuthResult.php');
abstract class WeiboService{
	
	/**
	 * 根据类型获取相应类型的微博服务
	 * @param string $type 微博类型标识，如sina,qq等
	 * @return WeiboService
	 */
	public static function getService($type){
		if(!$type) return null;
		$serviceClassName = ucfirst($type) . 'WeiboService';
		$serviceClassFile = WEIBO_SERVICE_LIB_PATH . $type .'/'. $serviceClassName . '.php';
		if(!include_once($serviceClassFile)){
			//找不到相应类型的微博服务
			return null;
		}
		$serviceClass = new ReflectionClass($serviceClassName);
		$service = $serviceClass->newInstance();
		return $service;
	}
	
	
	/**
	 * 该接口实现微博认证
	 * @param WeiboParam $weiboParam
	 * 	微博参数类，里面带有认证所需的参数
	 */
	public abstract function auth($weiboParam);
	
	/**
	 * 处理认证回调，保存认证结果
	 * @param WeiboParam $weiboParam
	 * 	微博参数类，里面带有认证所需的参数
	 * @return WeiboAuthResult
	 * 	认证结果
	 */
	public abstract function authCallBack($weiboParam);
	
	/**
	 * 获取某个用户的各种消息未读数 
	 */
	public abstract function getUserUnReadCount($weiboParam);
	
	/**
	 * 发送微博
	 * @param WeiboParam $weiboParam
	 * @param string $message
	 */
	public abstract function send($weiboParam, $message);
}