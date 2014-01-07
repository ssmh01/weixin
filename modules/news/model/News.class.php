<?php
/**
 *  资讯数据模型
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-26
 * 
 */
class News extends DynamicModelTransformSupport{

	/**
	 * 标题 
	 * @var int 
	 */
	private $id;

	/**
	 * 标题 
	 * @var string 
	 */
	private $title;

	/**
	 * 分类ID 
	 * @var int 
	 */
	private $cateId;

	/**
	 * 内容 
	 * @var string 
	 */
	private $content;

	/**
	 * 浏览数 
	 * @var int 
	 */
	private $views;

	/**
	 * 排序 
	 * @var int 
	 */
	private $sortNum;

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
	 * @return string 
	 */
	public function getTitle(){ 
		return $this->title;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setTitle($title){ 
		$this->title = $title; 
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
	 * @param int  
	 */
	public function setCateId($cateId){ 
		$this->cateId = $cateId; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getContent(){ 
		return $this->content;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setContent($content){ 
		$this->content = $content; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getViews(){ 
		return $this->views;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setViews($views){ 
		$this->views = $views; 
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