<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-02-15
 * 
 */
class Bind extends DynamicModelTransformSupport{

	/**
	 * 绑定用户 
	 * @var int 
	 */
	private $id;

	/**
	 * 绑定用户 
	 * @var int 
	 */
	private $userId;

	/**
	 * 绑定微博 
	 * @var int 
	 */
	private $weiboId;

	/**
	 * 绑定账号 
	 * @var string 
	 */
	private $account;

	/**
	 * 绑定密码 
	 * @var string 
	 */
	private $password;

	/**
	 * 绑定数据 
	 * @var string 
	 */
	private $datas;

	/**
	 * 创建时间 
	 * @var int 
	 */
	private $createTime;

	/**
	 * 
	 * @return int 
	 */
	public function getId(){ 
		return $this->id;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setId($id){ 
		$this->id = $id; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getUserId(){ 
		return $this->userId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setUserId($userId){ 
		$this->userId = $userId; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getWeiboId(){ 
		return $this->weiboId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setWeiboId($weiboId){ 
		$this->weiboId = $weiboId; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getAccount(){ 
		return $this->account;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setAccount($account){ 
		$this->account = $account; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getPassword(){ 
		return $this->password;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setPassword($password){ 
		$this->password = $password; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getDatas(){ 
		return $this->datas;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setDatas($datas){ 
		$this->datas = $datas; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getCreateTime(){ 
		return $this->createTime;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setCreateTime($createTime){ 
		$this->createTime = $createTime; 
	}
	
}?>