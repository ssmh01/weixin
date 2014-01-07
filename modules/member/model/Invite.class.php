<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-02-25
 * 
 */
class Invite extends DynamicModelTransformSupport{

	/**
	 * 邀请人ID 
	 * @var int 
	 */
	private $id;

	/**
	 * 邀请人ID 
	 * @var int 
	 */
	private $inviterId;

	/**
	 * 被邀请人ID 
	 * @var int 
	 */
	private $inviteeId;

	/**
	 * 邀请充值提成比例 
	 * @var double 
	 */
	private $rechargePercent;

	/**
	 * 邀请用户注册赠送积分 
	 * @var int 
	 */
	private $integral;

	/**
	 * 邀请时间 
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
	public function getInviterId(){ 
		return $this->inviterId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setInviterId($inviterId){ 
		$this->inviterId = $inviterId; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getInviteeId(){ 
		return $this->inviteeId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setInviteeId($inviteeId){ 
		$this->inviteeId = $inviteeId; 
	}

	/**
	 * 
	 * @return double 
	 */
	public function getRechargePercent(){ 
		return $this->rechargePercent;
	}

	/**
	 * 
	 * @param double  
	 */
	public function setRechargePercent($rechargePercent){ 
		$this->rechargePercent = $rechargePercent; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getIntegral(){ 
		return $this->integral;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setIntegral($integral){ 
		$this->integral = $integral; 
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