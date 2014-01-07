<?php

/**
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-1-7
 */
class WeiboParam{
	
	/**
	 * 微博类型标识
	 * @var string
	 */
	private $weiboType;
	
	/**
	 * 微博应用标识,在申请应用时由微博官方给你分配的应用标识
	 * @var string
	 */
	private $appKey;
	
	/**
	 * 微博应用密钥，在申请应用时由微博官方给你分配的应用密钥
	 * @var string
	 */
	private $appSecret;
	
	/**
	 * 微博用户认证授权时的回调URL，在这个页面里主要处理认证授权结果
	 * @var string
	 */
	private $callBack;
	
	/**
	 * 认证结果
	 * @var array
	 */
	private $authResult;
	
	/**
	 * 不包含上面参数的其它参数
	 * @var array
	 */
	private $others;
	
	
	public function __construct($weiboType, $appKey, $appSecret, $callBack, $authResult, $others){
		$this->setWeiboType($weiboType);
		$this->setAppKey($appKey);
		$this->setAppSecret($appSecret);
		$this->setCallBack($callBack);
		$this->setAuthResult($authResult);
		$this->setOthers($others);
	}
	
	/**
	 * @return the $weiboType
	 */
	public function getWeiboType() {
		return $this->weiboType;
	}

	/**
	 * @return the $appKey
	 */
	public function getAppKey() {
		return $this->appKey;
	}

	/**
	 * @return the $appSecret
	 */
	public function getAppSecret() {
		return $this->appSecret;
	}

	/**
	 * @return the $callBack
	 */
	public function getCallBack() {
		return $this->callBack;
	}

	/**
	 * @return the $others
	 */
	public function getOthers() {
		return $this->others;
	}

	/**
	 * @param string $weiboType
	 */
	public function setWeiboType($weiboType) {
		$this->weiboType = $weiboType;
	}

	/**
	 * @param string $appKey
	 */
	public function setAppKey($appKey) {
		$this->appKey = $appKey;
	}

	/**
	 * @param string $appSecret
	 */
	public function setAppSecret($appSecret) {
		$this->appSecret = $appSecret;
	}

	/**
	 * @param string $callBack
	 */
	public function setCallBack($callBack) {
		$this->callBack = $callBack;
	}

	/**
	 * @param array $others
	 */
	public function setOthers($others) {
		$this->others = $others;
	}
	
	/**
	 * @return the $authResult
	 */
	public function getAuthResult() {
		return $this->authResult;
	}

	/**
	 * @param array $authResult
	 */
	public function setAuthResult($authResult) {
		$this->authResult = $authResult;
	}
}