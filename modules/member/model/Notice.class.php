<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-01-06
 * 
 */
class Notice extends DynamicModelTransformSupport{

	/**
	 * 动作发起人 
	 * @var int 
	 */
	private $id;

	/**
	 * 动作发起人 
	 * @var int 
	 */
	private $fromUid;

	/**
	 * 通知接收人 
	 * @var int 
	 */
	private $toUid;

	/**
	 * 通知类型 
	 * @var string 
	 */
	private $type;

	/**
	 * 是否是新通知 
	 * @var int 
	 */
	private $new;

	/**
	 * 通知 
	 * @var string 
	 */
	private $notice;

	/**
	 * 发信时间 
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
	public function getFromUid(){ 
		return $this->fromUid;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setFromUid($fromUid){ 
		$this->fromUid = $fromUid; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getToUid(){ 
		return $this->toUid;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setToUid($toUid){ 
		$this->toUid = $toUid; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getType(){ 
		return $this->type;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setType($type){ 
		$this->type = $type; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getNew(){ 
		return $this->new;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setNew($new){ 
		$this->new = $new; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getNotice(){ 
		return $this->notice;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setNotice($notice){ 
		$this->notice = $notice; 
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