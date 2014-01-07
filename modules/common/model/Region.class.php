<?php
/**
 * 地区数据模型
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class Region extends DynamicModelTransformSupport{
	
	/**
	 * 国家级别
	 * @var int
	 */
	const TYPE_COUNTRY   = 0;
	
	/**
	 * 省份级别
	 * @var int
	 */
	const TYPE_PROVINCE  = 1;
	
	/**
	 * 城市级别
	 * @var int
	 */
	const TYPE_CITY      = 2;
	
	/**
	 * 镇区级别
	 * @var int
	 */
	const TYPE_DISTRICT  = 3;
	
	/**
	 * 中国的ID
	 * @var int
	 */
	const ID_CHINA = 1;

	/**
	 * 主键
	 * @var int 
	 */
	private $id;

	/**
	 * 名称 
	 * @var string 
	 */
	private $name;

	/**
	 * 上级区域 
	 * @var int 
	 */
	private $parentId;

	/**
	 * 区域类型　0：国，1：省，2：市 
	 * @var int 
	 */
	private $type;

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
	 * @return int 
	 */
	public function getParentId(){ 
		return $this->parentId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setParentId($parentId){ 
		$this->parentId = $parentId; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getType(){ 
		return $this->type;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setType($type){ 
		$this->type = $type; 
	}
	
}?>