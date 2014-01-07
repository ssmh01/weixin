<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-01-23
 * 
 */
class Io extends DynamicModelTransformSupport{
	

	const WEALTH_TYPE_MONEY = 1;
	const WEALTH_TYPE_INTEGRAL = 2;
	
	/**
	 * 完善个人资料赠送
	 * @var int
	 */
	const TYPE_FINISH_USER_INFO_REWARD = 101;

	/**
	 * 支出人ID, 
	 * @var int 
	 */
	private $id;

	/**
	 * 支出人ID, 
	 * @var int 
	 */
	private $fromUserId;

	/**
	 * 收入人ID, 
	 * @var int 
	 */
	private $toUserId;

	/**
	 * 支出标题 
	 * @var string 
	 */
	private $fromTitle;

	/**
	 * 收入标题 
	 * @var string 
	 */
	private $toTitle;

	/**
	 * 收支类型,如充值，投资 
	 * @var int 
	 */
	private $type;

	/**
	 * 收支源ID 
	 * @var int 
	 */
	private $sourceId;

	/**
	 * 财富类型 
	 * @var int 
	 */
	private $wealthType;

	/**
	 * 财富数 
	 * @var int 
	 */
	private $wealth;

	/**
	 * 税 
	 * @var int 
	 */
	private $tax;

	/**
	 * 支出人余额 
	 * @var int 
	 */
	private $fromBalance;

	/**
	 * 收入人余额 
	 * @var int 
	 */
	private $toBalance;

	/**
	 * 说明 
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
	 * @return int 
	 */
	public function getFromUserId(){ 
		return $this->fromUserId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setFromUserId($fromUserId){ 
		$this->fromUserId = $fromUserId; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getToUserId(){ 
		return $this->toUserId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setToUserId($toUserId){ 
		$this->toUserId = $toUserId; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getFromTitle(){ 
		return $this->fromTitle;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setFromTitle($fromTitle){ 
		$this->fromTitle = $fromTitle; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getToTitle(){ 
		return $this->toTitle;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setToTitle($toTitle){ 
		$this->toTitle = $toTitle; 
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
	public function getSourceId(){ 
		return $this->sourceId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setSourceId($sourceId){ 
		$this->sourceId = $sourceId; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getWealthType(){ 
		return $this->wealthType;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setWealthType($wealthType){ 
		$this->wealthType = $wealthType; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getWealth(){ 
		return $this->wealth;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setWealth($wealth){ 
		$this->wealth = $wealth; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getTax(){ 
		return $this->tax;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setTax($tax){ 
		$this->tax = $tax; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getFromBalance(){ 
		return $this->fromBalance;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setFromBalance($fromBalance){ 
		$this->fromBalance = $fromBalance; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getToBalance(){ 
		return $this->toBalance;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setToBalance($toBalance){ 
		$this->toBalance = $toBalance; 
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