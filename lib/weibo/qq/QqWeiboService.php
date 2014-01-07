<?php

/** 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-1-7
 */
include_once ('Oauth.class.php');
class QqWeiboService extends WeiboService{
	private static $QQ_SCOPE = '';
	
	/*
	 * @see WeiboService::auth()
	 */
	public function auth($weiboParam){
		//-------生成唯一随机串防CSRF攻击
		$state = md5(uniqid(rand(), TRUE));
		HttpSession::set('state', $state);
		
		$qqAuth = new Oauth();
		$qqAuthUrl = $qqAuth->get_login_url($weiboParam->getAppKey(), $weiboParam->getCallBack(), self::$QQ_SCOPE, $state);
		header("location:" . $qqAuthUrl);
	}
	
	/*
	 * @see WeiboService::authCallBack()
	 */
	public function authCallBack($weiboParam){
		$authResult = new WeiboAuthResult();

		$state = HttpSession::get('state');
		
		//--------验证state防止CSRF攻击
		if($_GET['state'] == $state)
		{
			$qqAuth = new Oauth();
			$access_token = $qqAuth->qq_callback($weiboParam->getAppKey(), $weiboParam->getAppSecret(), $weiboParam->getCallBack());
			if(!empty($access_token))
			{
				$openid = $qqAuth->get_openid($access_token);
				if(!empty($openid))
				{
					$authResult->setSuccess(true);
					
					//构造返回内容
					$resultArray = array(
						'authResult' => array(
							'access_token' => $access_token,
							'uid' => $openid
						)						
					);
					$authResult->setResult($resultArray);
				}
				else 
				{
					$authResult->setSuccess(false);
					$authResult->setMessage('获取OPENID失败');
				}				
				
			}
			else 
			{
				$authResult->setSuccess(false);
				$authResult->setMessage('获取token失败');				
			}
		}
		else
		{
			$authResult->setSuccess(false);
			$authResult->setMessage('CSRF验证失败');
		}
		
		return $authResult;
	}
	
	/**
	 *
	 * @see WeiboService::getUserUnReadCount()
	 */
	public function getUserUnReadCount($weiboParam){
		
	}
	
	/*
	 * @see WeiboService::send()
	 */
	public function send($weiboParam, $message){
		$datas = $weiboParam->getAuthResult();
		$qqAuth = new Oauth();
		$result = $qqAuth->send_t($weiboParam->getAppKey(), $datas['authResult']['access_token'], $datas['authResult']['uid'], $message);
		$resultData = json_decode($result);
		
		//检查返回ret判断api是否成功调用
		if($resultData->ret == 0){
			return 1;
		}else{
			return 0;
		}		
	}
}

?>