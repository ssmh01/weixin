<?php

/** 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-1-7
 */
include_once ('saetv2.ex.class.php');
class SinaWeiboService extends WeiboService{
	
	/*
	 * @see WeiboService::auth()
	 */
	public function auth($weiboParam){
		$saeToAuth = new SaeTOAuthV2($weiboParam->getAppKey(), $weiboParam->getAppSecret());
		$authUrl = $saeToAuth->getAuthorizeURL($weiboParam->getCallBack());
		header("location:" . $authUrl);
	}
	
	/*
	 * @see WeiboService::authCallBack()
	 */
	public function authCallBack($weiboParam){
		$authResult = new WeiboAuthResult();
		if(isset($_REQUEST['code'])){
			$saeToAuth = new SaeTOAuthV2($weiboParam->getAppKey(), $weiboParam->getAppSecret());
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = $weiboParam->getCallBack();
			try{
				$token = $saeToAuth->getAccessToken('code', $keys);
				$authResult->setSuccess(true);
				$authResult->setResult(array(
					'authResult' => $token
				));
			}catch(OAuthException $e){
				$authResult->setSuccess(false);
				$authResult->setMessage($e->getMessage());
			}
		}else{
			$authResult->setSuccess(false);
			$authResult->setMessage("没有找到返回码");
		}
		return $authResult;
	}
	
	/**
	 *
	 * @see WeiboService::getUserUnReadCount()
	 */
	public function getUserUnReadCount($weiboParam){
		$authResult = $weiboParam->getAuthResult();
		$weiboClient = new SaeTClientV2($weiboParam->getAppKey(), $weiboParam->getAppSecret(), $authResult['authResult']['access_token']);
		$unReadCountRecord = $weiboClient->get_unread_count($authResult['authResult']['uid']);
		try{
			$unReadCount = $unReadCountRecord[status];
			$unReadCount += $unReadCountRecord[follower];
			$unReadCount += $unReadCountRecord[cmt];
			$unReadCount += $unReadCountRecord[dm];
			$unReadCount += $unReadCountRecord[mention_status];
			$unReadCount += $unReadCountRecord[mention_cmt];
			$unReadCount += $unReadCountRecord[group];
			$unReadCount += $unReadCountRecord[private_group];
			$unReadCount += $unReadCountRecord[notice];
			$unReadCount += $unReadCountRecord[invite];
			$unReadCount += $unReadCountRecord[badge];
			$unReadCount += $unReadCountRecord[photo];
		}catch(Exception $e){
			return 0;
		}
		return $unReadCount;
	}
	
	/*
	 * @see WeiboService::send()
	 */
	public function send($weiboParam, $message){
		$authResult = $weiboParam->getAuthResult();
		$weiboClient = new SaeTClientV2($weiboParam->getAppKey(), $weiboParam->getAppSecret(), $authResult['authResult']['access_token']);
		return $weiboClient->update($message);
	}
}

?>