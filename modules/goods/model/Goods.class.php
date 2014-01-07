<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-23
 * 
 */
class Goods extends DynamicModelTransformSupport{
	
	/**
	 * 名称
	 *
	 * @var int
	 */
	private $id;
	
	/**
	 * 名称
	 *
	 * @var string
	 */
	private $title;
	
	/**
	 * 商品图片
	 *
	 * @var string
	 */
	private $image;
	
	/**
	 * 详细
	 *
	 * @var string
	 */
	private $detail;
	
	/**
	 * 0：下架，1：上架，默认为1
	 *
	 * @var int
	 */
	private $status;
	
	/**
	 * 是否能抽奖
	 *
	 * @var int
	 */
	private $canLottery;
	private $lotteryCount;
	
	/**
	 * 中奖概率
	 *
	 * @var double
	 */
	private $probability;
	
	/**
	 * 是否能兑换
	 *
	 * @var int
	 */
	private $canExchange;
	
	/**
	 * 兑换金币
	 *
	 * @var int
	 */
	private $money;
	
	/**
	 * 用户金币下限
	 *
	 * @var int
	 */
	private $moneyLimit;
	
	/**
	 * 库存数
	 *
	 * @var int
	 */
	private $count;
	
	/**
	 * 中/兑奖次数
	 *
	 * @var int
	 */
	private $exchanges;
	
	/**
	 * 排序
	 *
	 * @var int
	 */
	private $sortNum;
	private $summary;
	
	/**
	 * 创建时间
	 *
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
	 * @param
	 *        	int
	 */
	public function setId($id){
		$this->id = $id;
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
	 * @return string
	 */
	public function getImage(){
		return $this->image;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setImage($image){
		$this->image = $image;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getDetail(){
		return $this->detail;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setDetail($detail){
		$this->detail = $detail;
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
	public function getCanLottery(){
		return $this->canLottery;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setCanLottery($canLottery){
		$this->canLottery = $canLottery;
	}
	
	/**
	 *
	 * @return double
	 */
	public function getProbability(){
		return $this->probability;
	}
	
	/**
	 *
	 * @param
	 *        	double
	 */
	public function setProbability($probability){
		$this->probability = $probability;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getCanExchange(){
		return $this->canExchange;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setCanExchange($canExchange){
		$this->canExchange = $canExchange;
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
	 * @param
	 *        	int
	 */
	public function setMoney($money){
		$this->money = $money;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getMoneyLimit(){
		return $this->moneyLimit;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setMoneyLimit($moneyLimit){
		$this->moneyLimit = $moneyLimit;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getSortNum(){
		return $this->sortNum;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setSortNum($sortNum){
		$this->sortNum = $sortNum;
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
	 *
	 * @return number $exchanges
	 */
	public function getExchanges(){
		return $this->exchanges;
	}
	
	/**
	 *
	 * @param number $exchanges        	
	 */
	public function setExchanges($exchanges){
		$this->exchanges = $exchanges;
	}
	
	/**
	 *
	 * @return number $count
	 */
	public function getCount(){
		return $this->count;
	}
	
	/**
	 *
	 * @param number $count        	
	 */
	public function setCount($count){
		$this->count = $count;
	}
	/**
	 *
	 * @return field_type $lotteryCount
	 */
	public function getLotteryCount(){
		return $this->lotteryCount;
	}
	
	/**
	 *
	 * @param field_type $lotteryCount        	
	 */
	public function setLotteryCount($lotteryCount){
		$this->lotteryCount = $lotteryCount;
	}
	
	/**
	 *
	 * @return field_type $summary
	 */
	public function getSummary(){
		return $this->summary;
	}
	
	/**
	 *
	 * @param field_type $summary        	
	 */
	public function setSummary($summary){
		$this->summary = $summary;
	}
}
?>