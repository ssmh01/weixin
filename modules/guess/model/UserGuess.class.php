<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-02-20
 * 
 */
class UserGuess extends DynamicModelTransformSupport{
	
	/**
	 * 
	 * @var int
	 */
	const TYPE_ATTENTION = '1';
	
	/**
	 * 邀请我参与的竞猜
	 * @var int
	 */
	const TYPE_INVITE = '2';

	/**
	 * 参与用户 
	 * @var int 
	 */
	private $id;

	/**
	 * 参与用户 
	 * @var int 
	 */
	private $toUid;
	
	private $fromUid;

	/**
	 * 参与的竞猜 
	 * @var int 
	 */
	private $guessId;

	/**
	 * 关系类型 
	 * @var int 
	 */
	private $type;

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
	public function getGuessId(){ 
		return $this->guessId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setGuessId($guessId){ 
		$this->guessId = $guessId; 
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
	
	/**
	 * @return number $toUid
	 */
	public function getToUid(){
		return $this->toUid;
	}

	/**
	 * @return field_type $fromUid
	 */
	public function getFromUid(){
		return $this->fromUid;
	}

	/**
	 * @param number $toUid
	 */
	public function setToUid($toUid){
		$this->toUid = $toUid;
	}

	/**
	 * @param field_type $fromUid
	 */
	public function setFromUid($fromUid){
		$this->fromUid = $fromUid;
	}
}?>