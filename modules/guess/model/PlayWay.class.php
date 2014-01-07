<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-01-10
 * 
 */
class PlayWay extends DynamicModelTransformSupport{

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
	 * 玩法类名，用与区别其它玩法,用于加载玩法解析器 
	 * @var string 
	 */
	private $class;

	/**
	 * 玩法参数,序列化参数类 
	 * @var string 
	 */
	private $parameter;

	/**
	 * 玩法简介 
	 * @var string 
	 */
	private $summary;
	
	/**
	 * 说明资讯ID
	 * @var int
	 */
	private $newsId;
	
	/**
	 * 玩法使用状态
	 * @var int
	 */
	private $status;
	
	/**
	 * 玩法适配器
	 * @var IPlayWayAdapter
	 */
	private $playWayAdapter;
	
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
	 * @return string 
	 */
	public function getClass(){ 
		return $this->class;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setClass($class){ 
		$this->class = $class; 
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
	 * @param string  
	 */
	public function setSummary($summary){ 
		$this->summary = $summary; 
	}
	
	/**
	 * @return string $parameter
	 */
	public function getParameter(){
		return $this->parameter;
	}
	
	/**
	 * @param string $parameter
	 */
	public function setParameter($parameter){
		$this->parameter = $parameter;
	}
	
	/**
	 * 获取玩法的路径
	 * @return string
	 */
	public function getPath(){
		return WEB_ROOT . GuessConstant::PLAYWAY_DIRECTORY . $this->getClass() . '/';
	}
	
	/**
	 * 获取玩法的适配器
	 * @return IPlayWayAdapter
	 */
	public function getPlayWayAdapter(){
		if(!$this->playWayAdapter){
			$className = $this->getClass() . 'PlayWayAdapter';
			$classFile = $this->getPath() . $className .'.class.php';
			include_once($classFile);
			$this->playWayAdapter = new $className();
		}
		return $this->playWayAdapter;
	}
	
	/**
	 * @return number $newsId
	 */
	public function getNewsId(){
		return $this->newsId;
	}

	/**
	 * @param number $newsId
	 */
	public function setNewsId($newsId){
		$this->newsId = $newsId;
	}

	/**
	 * @return number $status
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 * @param number $status
	 */
	public function setStatus($status){
		$this->status = $status;
	}
}?>