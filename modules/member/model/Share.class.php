<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-02-15
 * 
 */
class Share extends DynamicModelTransformSupport{
	
	/**
	 * 分享类型：竞猜
	 * @var int
	 */
	const TYPE_GUESS = 1;

	/**
	 * 分享类型 
	 * @var int 
	 */
	private $id;

	/**
	 * 分享类型 
	 * @var int 
	 */
	private $type;

	/**
	 * 用户 
	 * @var int 
	 */
	private $userId;

	/**
	 * 分享内容ID 
	 * @var int 
	 */
	private $shareId;

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
	public function getShareId(){ 
		return $this->shareId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setShareId($shareId){ 
		$this->shareId = $shareId; 
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