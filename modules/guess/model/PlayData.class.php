<?php
/**
 * 竞猜数据类
 * 
 * @author blueyb.java@gmail.com
 */
class PlayData{
	
	/**
	 * 玩法ID
	 * 
	 * @var int
	 */
	private $playWayId = '';
	
	/**
	 * 玩法名称
	 * 
	 * @var string
	 */
	private $playWayName = '';
	
	/**
	 * 赔率类型，默认为固定赔率
	 * int
	 */
	private $oddsType = Guess::ODDS_TYPE_FIXED;
	
	/**
	 * 投注财富数
	 * @var int
	 */
	private $wealth = 0;
	
	/**
	 * 选择
	 * @var string
	 */
	private $choose = '';
	
	/**
	 * 赢投注,输时为负数
	 * @var int
	 */
	private $winWealth;
	
	/**
	 * @var Play
	 */
	private $play;
	
	/**
	 * 检查是否是正确的数据
	 * @return boolean
	 */
	public function isPlay(){
		return $this->getChoose() != '' && $this->getWealth();
	}
	
	/**
	 * 是否是固定赔率
	 * @return boolean
	 */
	public function isFixedOdds(){
		return $this->oddsType == Guess::ODDS_TYPE_FIXED;
	}
	
	/**
	 * 是否是浮动赔率
	 * @return boolean
	 */
	public function isFloatOdds(){
		return $this->oddsType == Guess::ODDS_TYPE_FLOAT;
	}
	
	/**
	 * @return number $oddsType
	 */
	public function getOddsType(){
		return $this->oddsType;
	}

	/**
	 * @param number $oddsType
	 */
	public function setOddsType($oddsType){
		$this->oddsType = $oddsType;
	}

	/**
	 * @return number $wealth
	 */
	public function getWealth(){
		return $this->wealth;
	}

	/**
	 * @param number $wealth
	 */
	public function setWealth($wealth){
		$this->wealth = intval($wealth);
	}

	/**
	 * @return string $choose
	 */
	public function getChoose(){
		return $this->choose;
	}

	/**
	 * @param string $choose
	 */
	public function setChoose($choose){
		$this->choose = trim($choose);
	}

	/**
	 * @param number $winWealth
	 */
	public function setWinWealth($winWealth){
		$this->winWealth = $winWealth;
	}
	
	/**
	 * @return number $playWayId
	 */
	public function getPlayWayId(){
		return $this->playWayId;
	}

	/**
	 * @param number $playWayId
	 */
	public function setPlayWayId($playWayId){
		$this->playWayId = $playWayId;
	}

	/**
	 * @return string $playWayName
	 */
	public function getPlayWayName(){
		return $this->playWayName;
	}

	/**
	 * @param string $playWayName
	 */
	public function setPlayWayName($playWayName){
		$this->playWayName = $playWayName;
	}
	
	public function isWin(){
		return $this->winWealth > 0;
	}
	
	public function isLost(){
		return $this->winWealth < 0;
	}
	
	/**
	 * @return number $winWealth
	 */
	public function getWinWealth(){
		return $this->winWealth;
	}

	/**
	 * @return Play $play
	 */
	public function getPlay(){
		return $this->play;
	}

	/**
	 * @param Play $play
	 */
	public function setPlay($play){
		$this->play = $play;
	}

	
	
}

?>