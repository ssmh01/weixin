<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-01-06
 * 
 */
class Follow extends DynamicModelTransformSupport{

	/**
	 * 关注人 
	 * @var int 
	 */
	private $id;

	/**
	 * 关注人 
	 * @var int 
	 */
	private $fromUid;
	
	/**
	 * 关注人
	 * @var User
	 */
	private $fromUser;

	/**
	 * 被关注人 
	 * @var int 
	 */
	private $toUid;
	
	/**
	 * 关注人
	 * @var User
	 */
	private $toUser;

	/**
	 * 关注时间 
	 * @var int 
	 */
	private $addTime;

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
	 * @return int 
	 */
	public function getAddTime(){ 
		return $this->addTime;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setAddTime($addTime){ 
		$this->addTime = $addTime; 
	}
	
	/**
	 * @return User $fromUser
	 */
	public function getFromUser(){
		return $this->fromUser;
	}
	
	/**
	 * @param User $fromUser
	 */
	public function setFromUser($fromUser){
		$this->fromUser = $fromUser;
	}

	/**
	 * @return User $toUser
	 */
	public function getToUser(){
		return $this->toUser;
	}


	/**
	 * @param User $toUser
	 */
	public function setToUser($toUser){
		$this->toUser = $toUser;
	}
}?>