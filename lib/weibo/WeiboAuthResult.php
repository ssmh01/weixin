<?php

/**
 * 微博认证结果
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-1-7
 */
class WeiboAuthResult {
	
	/**
	 * 指示认证是否成功
	 * @var boolean
	 */
	private $success;
	
	/**
	 * 认证消息
	 * @var string
	 */
	private $message;
	
	/**
	 * 认证结果，如果认证失败就返回null
	 * @var array
	 */
	private $result;
	
	/**
	 * @return the $success
	 */
	public function isSuccess() {
		return $this->success;
	}

	/**
	 * @return the $message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return the $result
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @param boolean $success
	 */
	public function setSuccess($success) {
		$this->success = $success;
	}

	/**
	 * @param string $message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * @param array $result
	 */
	public function setResult($result) {
		$this->result = $result;
	}

	
	

}

?>