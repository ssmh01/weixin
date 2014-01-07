<?php
/**
 * 管理员
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-16
 * 
 */
class Manager extends DynamicModelTransformSupport{

	/**
	 * 名称 
	 * @var int 
	 */
	private $id;

	/**
	 * 名称 
	 * @var string 
	 */
	private $name;

	/**
	 * 密码 
	 * @var string 
	 */
	private $password;

	/**
	 * 手机 
	 * @var string 
	 */
	private $mobile;

	/**
	 * 管理组ID 
	 * @var int 
	 */
	private $groupId;

	/**
	 * 是否允许登陆 
	 * @var int 
	 */
	private $allowLogin;

	/**
	 * 上次登陆时间 
	 * @var int 
	 */
	private $lastLoginTime;

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
	 * @return string 
	 */
	public function getName(){ 
		return $this->name;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setName($name){ 
		$this->name = $name; 
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
	public function getMobile(){ 
		return $this->mobile;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setMobile($mobile){ 
		$this->mobile = $mobile; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getGroupId(){ 
		return $this->groupId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setGroupId($groupId){ 
		$this->groupId = $groupId; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getAllowLogin(){ 
		return $this->allowLogin;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setAllowLogin($allowLogin){ 
		$this->allowLogin = $allowLogin; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getLastLoginTime(){ 
		return $this->lastLoginTime;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setLastLoginTime($lastLoginTime){ 
		$this->lastLoginTime = $lastLoginTime; 
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