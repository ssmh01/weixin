<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-01-10
 * 
 */
class Guess extends DynamicModelTransformSupport{
	
	/**
	 * 未知赔率类型
	 * 
	 * @var int
	 */
	const ODDS_TYPE_UNKOWN = 0;
	
	/**
	 * 固定赔率类型
	 * 
	 * @var int
	 */
	const ODDS_TYPE_FIXED = 1;
	
	/**
	 * 浮动赔率类型
	 * 
	 * @var int
	 */
	const ODDS_TYPE_FLOAT = 2;
	
	/**
	 * 组合赔率类型
	 * 
	 * @var int
	 */
	const ODDS_TYPE_COMBINATION = 3;
	
	/**
	 * 投注下限名
	 * 
	 * @var string
	 */
	const NAME_BETTING_LOWER_LIMIT = 'bll';
	
	/**
	 * 投注上限名
	 * 
	 * @var string
	 */
	const NAME_BETTING_UPPER_LIMIT = 'bul';
	
	/**
	 * 财富类型:金币
	 * 
	 * @var int
	 */
	const WEALTH_TYPE_MONEY = 1;
	
	/**
	 * 财富类型:积分
	 * 
	 * @var int
	 */
	const WEALTH_TYPE_INTEGRAL = 2;
	
	/**
	 * 财富类型:吃喝玩乐
	 * 
	 * @var int
	 */
	const WEALTH_TYPE_EDPF = 3; 
	
	/**
	 * 竞猜状态[待审核]
	 * @var int
	 */
	const STATUS_WAITING_CKECK = 0;
	
	/**
	 * 竞猜状态[审核通过]
	 * @var int
	 */
	const STATUS_NORMAL = 1;
	
	/**
	 * 竞猜状态[提交判定]
	 * @var int
	 */
	const STATUS_WAITING_RUDGE = 2;
	
	/**
	 * 竞猜状态[结束]
	 * @var int
	 */
	const STATUS_END = 3;
	
	/**
	 * 竞猜状态[关闭]
	 * @var int
	 */
	const STATUS_CLOSE = 4;
	
	/**
	 * 参与角色:所有会员
	 * @var int
	 */
	const PLAY_ROLE_ALL = 0;
	
	/**
	 * 参与角色:好友
	 * @var int
	 */
	const PLAY_ROLE_FRIEND = 1;
	
	/**
	 * 坐庄用户
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * 坐庄用户
	 * 
	 * @var int
	 */
	private $userId;
	
	/**
	 * 竟猜类型
	 * 
	 * @var int
	 */
	private $custom;
	
	/**
	 * 竞猜点ID
	 * 
	 * @var int
	 */
	private $guessPointId;
	
	/**
	 * 竞猜点
	 * @var GuessPoint
	 */
	private $guessPoint;
	
	/**
	 * 分类Id
	 * 
	 * @var int
	 */
	private $cateId;
	
	/**
	 * 系统税收比例
	 * 
	 * @var double
	 */
	private $tax;
	
	/**
	 * 标题
	 * 
	 * @var string
	 */
	private $title;
	
	/**
	 * 参与竟猜开始时间
	 * 
	 * @var int
	 */
	private $playStartTime;
	
	/**
	 * 参与竟猜截止时间
	 * 
	 * @var int
	 */
	private $playDeadline;
	
	/**
	 * 赔率类型 0未知赔率 1为固定 2为浮动 3为组合
	 * 
	 * @var int
	 */
	private $oddsType;
	
	/**
	 * 竟猜财富类型
	 * 
	 * @var int
	 */
	private $wealthType;
	
	/**
	 * 自定义竟猜类型
	 * @var string
	 */
	private $customType;
	
	/**
	 * 参与竟猜人数
	 * 
	 * @var int
	 */
	private $playCount;
	
	/**
	 * 参与竟猜财富数
	 * 
	 * @var int
	 */
	private $playWealth;
	
	/**
	 * 托管金额
	 * 
	 * @var int
	 */
	private $keepWealth;
	
	/**
	 * 结果金额
	 * @var double
	 */
	private $winWealth;
	
	/**
	 * 多个竞猜玩法的数组数据(玩法ID,赔率类型，投注上下限,竞猜人数上限,赔率)
	 * 
	 * @var string
	 */
	private $playDatas = array();
	
	/**
	 * 竟猜的参数
	 * 
	 * @var string
	 */
	private $parameter;
	
	/**
	 * 参与角色
	 * 
	 * @var int
	 */
	private $playRole;
	
	/**
	 * 竞猜简介
	 * 
	 * @var string
	 */
	private $summary;
	
	/**
	 * 竟猜状态
	 * 
	 * @var int
	 */
	private $status;
	
	/**
	 * 创建时间
	 * 
	 * @var int
	 */
	private $createTime;
	
	/**
	 * 邀请好友
	 * 
	 * @var int
	 */
	private $invite_friend;
	
	/**
	 * 用户
	 * 
	 * @var User
	 */
	private $user;
	
	/**
	 *
	 * @return int
	 */
	public function getId(){
		return $this->id;
	}
	
	/**
	 *
	 * @param
	 *        	int
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
	 * @param
	 *        	int
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
	 * @param
	 *        	int
	 */
	public function setCustom($custom){
		$this->custom = $custom;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getGuessPointId(){
		return $this->guessPointId;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setGuessPointId($guessPointId){
		$this->guessPointId = $guessPointId;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getCateId(){
		return $this->cateId;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setCateId($cateId){
		$this->cateId = $cateId;
	}
	
	/**
	 *
	 * @return double
	 */
	public function getTax(){
		return $this->tax;
	}
	
	/**
	 *
	 * @param
	 *        	double
	 */
	public function setTax($tax){
		$this->tax = $tax;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getTitle(){
		return $this->title;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setTitle($title){
		$this->title = $title;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getPlayStartTime(){
		return $this->playStartTime;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setPlayStartTime($playStartTime){
		$this->playStartTime = $playStartTime;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getPlayDeadline(){
		return $this->playDeadline;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setPlayDeadline($playDeadline){
		$this->playDeadline = $playDeadline;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getOddsType(){
		return $this->oddsType;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setOddsType($oddsType){
		$this->oddsType = $oddsType;
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
	 * @param
	 *        	int
	 */
	public function setWealthType($wealthType){
		$this->wealthType = $wealthType;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getPlayCount(){
		return $this->playCount;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setPlayCount($playCount){
		$this->playCount = $playCount;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getPlayWealth(){
		return $this->playWealth;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setPlayWealth($playWealth){
		$this->playWealth = $playWealth;
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
	 * @param
	 *        	string
	 */
	public function setPlayDatas($playDatas){
		$this->playDatas = $playDatas;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getParameter(){
		return $this->parameter;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setParameter($parameter){
		$this->parameter = $parameter;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getPlayRole(){
		return $this->playRole;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setPlayRole($playRole){
		$this->playRole = $playRole;
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
	 * @param
	 *        	string
	 */
	public function setSummary($summary){
		$this->summary = $summary;
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
	 * @param
	 *        	int
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
	 * @param
	 *        	int
	 */
	public function setCreateTime($createTime){
		$this->createTime = $createTime;
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
	 * 计算需要托管的金额
	 * 
	 * @return int
	 */
	public function needKeepWealth(){
		$needKeepWealth = 0;
		foreach($this->getPlayDatas() as $playWayData){
			$needKeepWealth += $playWayData->needKeepWealth();
		}
		return $needKeepWealth;
	}
	
	/**
	 * 用户的金币是否足够
	 * 
	 * @param User $user        	
	 * @return boolean
	 */
	public function wealthIsEnough(User $user){
		$needKeepWealth = $this->needKeepWealth();
		$leaveWealth = 0;
		if($this->wealthTypeIsMoney()){
			$leaveWealth = $user->getAvailableMoney();
		}else if($this->wealthTypeIsIntegral()){
			$leaveWealth = $user->getAvailableIntegral();
		}
		return $leaveWealth >= $needKeepWealth;
	}
	
	/**
	 *
	 * @return User $user
	 */
	public function getUser(){
		return $this->user;
	}
	
	/**
	 *
	 * @param User $user        	
	 */
	public function setUser($user){
		$this->user = $user;
	}
	
	/**
	 *
	 * @return number $keepWealth
	 */
	public function getKeepWealth(){
		return $this->keepWealth;
	}
	
	/**
	 *
	 * @param number $keepWealth        	
	 */
	public function setKeepWealth($keepWealth){
		$this->keepWealth = $keepWealth;
	}
	
	/**
	 * 从玩法数据中分析赔率
	 */
	public function parseOddsType(){
		$isFixed = false;
		$isFloat = false;
		foreach($this->getPlayDatas() as $playWayData){
			if($playWayData->isFixedOdds()){
				$isFixed = true;
			}elseif($playWayData->isFloatOdds()){
				$isFloat = true;
			}
		}
		if($isFixed && $isFloat) return self::ODDS_TYPE_COMBINATION;
		if($isFixed) return self::ODDS_TYPE_FIXED;
		if($isFloat) return self::ODDS_TYPE_FLOAT;
		return self::ODDS_TYPE_UNKOWN;
	}
	
	public function isPlaying(){
		return $this->status == Guess::STATUS_NORMAL && $this->playDeadline > time();
	}
	
	public function getWealthTypeName(){
		if($this->wealthTypeIsMoney()){
			return "金币";
		}elseif($this->wealthTypeIsIntegral()){
			return  "积分";
		}else{
			return "吃喝玩乐";
		}
	}
	
	public function addPlayData(PlayWayData $playWayData){
		$this->playDatas[$playWayData->getId()] = $playWayData;
	}
	
	/**
	 * 是否只对好友开放
	 * @return boolean
	 */
	public function justFriendCanPlay(){
		return $this->playRole == self::PLAY_ROLE_FRIEND;
	}
	
	/**
	 * @return string $customType
	 */
	public function getCustomType(){
		return $this->customType;
	}

	/**
	 * @param string $customType
	 */
	public function setCustomType($customType){
		$this->customType = $customType;
	}
	/**
	 * @return GuessPoint $guessPoint
	 */
	public function getGuessPoint(){
		return $this->guessPoint;
	}

	/**
	 * @param GuessPoint $guessPoint
	 */
	public function setGuessPoint($guessPoint){
		$this->guessPoint = $guessPoint;
	}
	
	/**
	 * @return number $winWealth
	 */
	public function getWinWealth(){
		return $this->winWealth;
	}

	/**
	 * @param number $winWealth
	 */
	public function setWinWealth($winWealth){
		$this->winWealth = $winWealth;
	}

	public function setInviteFriend($flag){
		$this->invite_friend = $flag;
	}
	
	public function getInviteFriend(){
		return $this->invite_friend;
	}
	
}
?>