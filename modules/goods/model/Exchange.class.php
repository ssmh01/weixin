<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-23
 * 
 */
class Exchange extends DynamicModelTransformSupport{

	/**
	 * 商品
	 * @var int
	 */
	private $id;
	
	/**
	 * 商品
	 * @var int
	 */
	private $goodsId;
	
	/**
	 * 商品
	 * @var int
	 */
	private $userId;
	
	/**
	 * 是否是抽奖奖品
	 * @var int
	 */
	private $isLottery;
	
	/**
	 * 是否兑换是兑换
	 * @var int
	 */
	private $isExchange;
	
	/**
	 * 兑换金币
	 * @var int
	 */
	private $money;
	
	/**
	 * 收货人姓名
	 * @var string
	 */
	private $username;
	
	/**
	 * 收货人手机
	 * @var string
	 */
	private $mobile;
	
	/**
	 * 收货人地址
	 * @var string
	 */
	private $address;
	
	/**
	 * 发货状态，0：未发货，1：已发货，默认为0
	 * @var int
	 */
	private $sendStatus;
	
	/**
	 * 收货状态，0：未收货，1：已收货，默认为0
	 * @var int
	 */
	private $receiveStatus;
	
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
	public function getGoodsId(){
		return $this->goodsId;
	}
	
	/**
	 *
	 * @param int
	 */
	public function setGoodsId($goodsId){
		$this->goodsId = $goodsId;
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
	public function getIsLottery(){
		return $this->isLottery;
	}
	
	/**
	 *
	 * @param int
	 */
	public function setIsLottery($isLottery){
		$this->isLottery = $isLottery;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getIsExchange(){
		return $this->isExchange;
	}
	
	/**
	 *
	 * @param int
	 */
	public function setIsExchange($isExchange){
		$this->isExchange = $isExchange;
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
	public function getUsername(){
		return $this->username;
	}
	
	/**
	 *
	 * @param string
	 */
	public function setUsername($username){
		$this->username = $username;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getMobile(){
		return $this->mobile;
	}
	
	/**
	 *
	 * @param string
	 */
	public function setMobile($mobile){
		$this->mobile = $mobile;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getAddress(){
		return $this->address;
	}
	
	/**
	 *
	 * @param string
	 */
	public function setAddress($address){
		$this->address = $address;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getSendStatus(){
		return $this->sendStatus;
	}
	
	/**
	 *
	 * @param int
	 */
	public function setSendStatus($sendStatus){
		$this->sendStatus = $sendStatus;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getReceiveStatus(){
		return $this->receiveStatus;
	}
	
	/**
	 *
	 * @param int
	 */
	public function setReceiveStatus($receiveStatus){
		$this->receiveStatus = $receiveStatus;
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