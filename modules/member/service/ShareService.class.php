<?php

/**
 * 分享服务接口实现
 * @author blueyb.java@gmail.com
 */
class ShareService implements IShareService{
	
	/**
	 * @see IShareService::share()
	 */
	public function share($message, $bind){
		$weiboDao = MD('Weibo');
		$weibo = $weiboDao->get($bind['weibo_id']);
		if(!$weibo) return false;
		$authResult = unserialize($bind['datas']);
		include(EXT_LIB_ROOT . 'weibo/WeiboService.php');
		$weiboParam = new WeiboParam($weibo['type'], $weibo['app_key'], $weibo['app_secret'], '', $authResult);
		$weiboService = WeiboService::getService($weibo['type']);
		if(!$weiboService) return false;
		return $weiboService->send($weiboParam, $message);
	}
}

?>