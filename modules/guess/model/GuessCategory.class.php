<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-01-10
 * 
 */
class GuessCategory extends DynamicModelTransformSupport{

	/**
	 * 名称 
	 * @var int 
	 */
	private $id;

	/**
	 * 名称 
	 * @var string 
	 */
	private $name;

	/**
	 * 父分类 
	 * @var int 
	 */
	private $parentId;

	/**
	 * 竞猜玩法ID, 
	 * @var string 
	 */
	private $playWays;
	
	/**
	 * 竞猜点参数个数
	 * @var int
	 */
	private $parameterCount;

	/**
	 * 固定赔率状态 
	 * @var int 
	 */
	private $fixedOdds;

	/**
	 * 浮动赔率状态 
	 * @var int 
	 */
	private $floatOdds;

	/**
	 * 分类使用状态 
	 * @var int 
	 */
	private $status;

	/**
	 * 排序 
	 * @var int 
	 */
	private $sortNum;

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
	 * @return string 
	 */
	public function getName(){ 
		return $this->name;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setName($name){ 
		$this->name = $name; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getParentId(){ 
		return $this->parentId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setParentId($parentId){ 
		$this->parentId = $parentId; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getPayTypes(){ 
		return $this->playWays;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setPayTypes($payTypes){ 
		$this->playWays = $payTypes; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getFixedOdds(){ 
		return $this->fixedOdds;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setFixedOdds($fixedOdds){ 
		$this->fixedOdds = $fixedOdds; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getFloatOdds(){ 
		return $this->floatOdds;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setFloatOdds($floatOdds){ 
		$this->floatOdds = $floatOdds; 
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
	public function getSortNum(){ 
		return $this->sortNum;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setSortNum($sortNum){ 
		$this->sortNum = $sortNum; 
	}
	
	/**
	 * @return number $parameterCount
	 */
	public function getParameterCount(){
		return $this->parameterCount;
	}

	/**
	 * @param number $parameterCount
	 */
	public function setParameterCount($parameterCount){
		$this->parameterCount = $parameterCount;
	}
}?>