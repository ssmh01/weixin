<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-01-10
 * 
 */
class GuessPoint extends DynamicModelTransformSupport{
	
	const STATUS_UNUSE = 0;
	
	const STATUS_NORMAL = 1;
	
	/**
	 * 已判定
	 * @var unknown
	 */
	const STATUS_RUDGED = 2;
	
	/**
	 * 竞猜点类型
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * 分类Id
	 * 
	 * @var int
	 */
	private $cateId;
	
	/**
	 * 竞猜点标题
	 * 
	 * @var string
	 */
	private $title;
	
	/**
	 * 竞猜个数
	 * 
	 * @var int
	 */
	private $guessCount;
	
	/**
	 * 参与竟猜截止时间
	 * 
	 * @var int
	 */
	private $playDeadline;
	
	/**
	 * 竞猜点参数数组
	 * 
	 * @var string
	 */
	private $params;
	
	/**
	 * 启用状态
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
	 * 竞猜分类
	 * @var GuessCategory
	 */
	private $guessCategory;
	
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
	 * @return string
	 */
	public function getParams(){
		return $this->params;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setParams($params){
		$this->params = $params;
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
	 * @return number $guessCount
	 */
	public function getGuessCount(){
		return $this->guessCount;
	}
	
	/**
	 *
	 * @param number $guessCount        	
	 */
	public function setGuessCount($guessCount){
		$this->guessCount = $guessCount;
	}
	/**
	 *
	 * @return number $status
	 */
	public function getStatus(){
		return $this->status;
	}
	
	/**
	 *
	 * @param number $status        	
	 */
	public function setStatus($status){
		$this->status = $status;
	}
	
	/**
	 * @return GuessCategory $guessCategory
	 */
	public function getGuessCategory(){
		return $this->guessCategory;
	}

	/**
	 * @param GuessCategory $guessCategory
	 */
	public function setGuessCategory($guessCategory){
		$this->guessCategory = $guessCategory;
	}
}
?>