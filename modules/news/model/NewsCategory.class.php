<?php
/**
 * 资讯分类数据模型
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-26
 * 
 */
class NewsCategory extends DynamicModelTransformSupport{
	
	/**
	 * 系统公告
	 * @var int
	 */
	const TYPE_BULLETION = 1;
	
	/**
	 * 资金保障
	 * @var int
	 */
	const TYPE_FINANCIAL_SECURITY = 1;
	
	/**
	 * 优贷理财
	 * @var int
	 */
	const TYPE_FINANCIAL_MANAGE = 3;
	
	/**
	 * 常见问题
	 * @var int
	 */
	const TYPE_QUESTION = 4;
	
	/**
	 * 行业新闻
	 * @var int
	 */
	const TYPE_NEWS = 5;
	
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
	 * 分类类型 
	 * @var int 
	 */
	private $type;

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
	
}?>