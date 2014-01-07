<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-02-20
 * 
 */
class Play extends DynamicModelTransformSupport{
	
	/**
	 * 已判定状态
	 * @var int
	 */
	const STATUS_REDGED = 1;
	
	/**
	 * 自己定义竞猜总赢财富
	 * @var double
	 */
	const WIN_WEALTH_CUSTOM = 1.00;
	
	/**
	 * 自己定义竞猜总输财富
	 * @var double
	 */
	const LOST_WEALTH_CUSTOM = -1.00;

	/**
	 * Id
	 * @var int 
	 */
	private $id;

	/**
	 * 参与用户ID 
	 * @var int 
	 */
	private $userId;
	
	/**
	 * 参与用户
	 * @var User
	 */
	private $user;

	/**
	 * 竟猜类型 
	 * @var int 
	 */
	private $custom;

	/**
	 * 参与的竞猜ID
	 * @var int 
	 */
	private $guessId;
	
	/**
	 * 参与的竞猜
	 * @var Guess
	 */
	private $guess;

	/**
	 * 竟猜财富类型 
	 * @var int 
	 */
	private $wealthType;
	
	/**
	 * 总投注
	 * @var int
	 */
	private $wealth;
	
	/**
	 * 总赢投注,输时为负数
	 * @var int
	 */
	private $winWealth;

	/**
	 * 竞猜数据 
	 * @var string 
	 */
	private $playDatas = array();

	/**
	 * 竞猜是否已判定 
	 * @var int 
	 */
	private $status;

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
	public function getCustom(){ 
		return $this->custom;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setCustom($custom){ 
		$this->custom = $custom; 
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
	 * 是否是金币类型财富
	 * return boolean
	 */
	public function wealthTypeIsMoney(){
		return $this->wealthType == Guess::WEALTH_TYPE_MONEY;
	}
	/**
	 * 是否是积分类型财富
	 * return boolean
	 */
	public function wealthTypeIsIntegral(){
		return $this->wealthType == Guess::WEALTH_TYPE_INTEGRAL;
	}

	/**
	 * 
	 * @return string 
	 */
	public function getPlayDatas(){ 
		return $this->playDatas;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setPlayDatas($playDatas){ 
		$this->playDatas = $playDatas; 
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
	
	/**
	 * @param PlayData $playData
	 */
	public function addPlayData(PlayData $playData=null){
		if(!$playData) return false;
		$this->playDatas[$playData->getPlayWayId()] = $playData;
	}
	
	public function isEmpty(){
		return !$this->getPlayDatas();
	}
	
	/**
	 * @return Guess $guess
	 */
	public function getGuess(){
		return $this->guess;
	}

	/**
	 * @param Guess $guess
	 */
	public function setGuess($guess){
		$this->guess = $guess;
	}
	
	/**
	 * @return User $user
	 */
	public function getUser(){
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser($user){
		$this->user = $user;
	}
	
	/**
	 * 获取总投注
	 */
	public function getPlayWealth(){
		if($this->getCustom()) return 0;
		$playWealth = 0;
		foreach($this->playDatas as $playData){
			$playWealth += $playData->getWealth();
		}
		return $playWealth;
	}
	
	/**
	 * @return number $wealth
	 */
	public function getWealth(){
		return $this->wealth;
	}

	/**
	 * @return number $winWealth
	 */
	public function getWinWealth(){
		return $this->winWealth;
	}

	/**
	 * @param number $wealth
	 */
	public function setWealth($wealth){
		$this->wealth = $wealth;
	}

	/**
	 * @param number $winWealth
	 */
	public function setWinWealth($winWealth){
		$this->winWealth = $winWealth;
	}

	public function isWin(){
		return $this->winWealth > 0;
	}
	
	public function getBasWinWealth(){
		return abs($this->winWealth);
	}
	
	public function getFirstPlayData(){
		reset($this->playDatas);
		return current($this->playDatas);
	}
	
}?>