<?php
/**
 * 菜单
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-16
 * 
 */
class Menu extends DynamicModelTransformSupport{

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
	 * 链接地址 
	 * @var string 
	 */
	private $url;

	/**
	 * 父菜单 
	 * @var int 
	 */
	private $parentId;

	/**
	 * 0：不显示，1：显示，默认为1 
	 * @var int 
	 */
	private $status;

	/**
	 * 是否为系统内置，0否1是 
	 * @var int 
	 */
	private $isSystem;

	/**
	 * 排序 
	 * @var int 
	 */
	private $sortNum;

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
	public function getUrl(){ 
		return $this->url;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setUrl($url){ 
		$this->url = $url; 
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
	public function getStatus(){ 
		return $this->status;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setStatus($status){ 
		$this->status = $status; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getIsSystem(){ 
		return $this->isSystem;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setIsSystem($isSystem){ 
		$this->isSystem = $isSystem; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getSortNum(){ 
		return $this->sortNum;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setSortNum($sortNum){ 
		$this->sortNum = $sortNum; 
	}
	/**
	 * 
	 * @return array 
	 */
	public function getMap() { 
		$map = array(
					'id'=>'id',
					'name'=>'name',
					'url'=>'url',
					'parentId'=>'parent_id',
					'status'=>'status',
					'isSystem'=>'is_system',
					'sortNum'=>'sort_num'
				);
		return $map;
	}
}?>