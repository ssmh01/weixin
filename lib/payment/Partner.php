<?php

/**
 * 支付接口的合作者.注意,并不是所有的支付接口都包含类中所定义的属性.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -   2011-08-16
 */
class Partner{
	
	/**
	 * 合作ID
	 */
	private $id;
	
	/**
	 * 合作密钥
	 */
	private $key;
	
	/**
	 * 合作者账号
	 */
	private $account;
	
	public function __construct($id, $key, $account){
		$this->setId($id);
		$this->setKey($key);
		$this->setAccount($account);
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $key
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @param field_type $key
	 */
	public function setKey($key) {
		$this->key = $key;
	}

	/**
	 * @return the $account
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * @param field_type $account
	 */
	public function setAccount($account) {
		$this->account = $account;
	}
}