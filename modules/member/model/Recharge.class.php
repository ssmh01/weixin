<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-23
 * 
 */
class Recharge extends DynamicModelTransformSupport{

	/**
	 * 用户ID 
	 * @var int 
	 */
	private $id;
	
	/**
	 * 充值编号
	 * @var string
	 */
	private $sn;

	/**
	 * 用户ID 
	 * @var int 
	 */
	private $userId;

	/**
	 * 充值的金额 
	 * @var int 
	 */
	private $money;

	/**
	 * 支付类型, 
	 * @var string 
	 */
	private $payType;

	/**
	 * 充值状态 
	 * @var int 
	 */
	private $status;

	/**
	 * 注册时间 
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
	 * @return string $sn
	 */
	public function getSn(){
		return $this->sn;
	}
	
	/**
	 * @param string $sn
	 */
	public function setSn($sn){
		$this->sn = $sn;
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
	public function getMoney(){ 
		return $this->money;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setMoney($money){ 
		$this->money = $money; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getPayType(){ 
		return $this->payType;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setPayType($payType){ 
		$this->payType = $payType; 
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