<?php
/**
 * 管理组
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-16
 */
class ManageGroup extends DynamicModelTransformSupport{

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
	 * 权限 
	 * @var string 
	 */
	private $permissions;

	/**
	 * 简介 
	 * @var string 
	 */
	private $summary;

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
	public function getPermissions(){ 
		return $this->permissions;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setPermissions($permissions){ 
		$this->permissions = $permissions; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getSummary(){ 
		return $this->summary;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setSummary($summary){ 
		$this->summary = $summary; 
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