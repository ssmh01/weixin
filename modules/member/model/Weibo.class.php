<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2013-02-15
 * 
 */
class Weibo extends DynamicModelTransformSupport{
	
	

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
	 * logo图片 
	 * @var string 
	 */
	private $logo;

	/**
	 * 类型代码 
	 * @var string 
	 */
	private $type;

	/**
	 * 应用KEY 
	 * @var string 
	 */
	private $appKey;

	/**
	 * 应用KEY 
	 * @var string 
	 */
	private $appSecret;

	/**
	 * 链接地址 
	 * @var string 
	 */
	private $url;

	/**
	 * 排序 
	 * @var int 
	 */
	private $sortNum;

	/**
	 * 0：不显示，1：显示，默认为1 
	 * @var int 
	 */
	private $status;

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
	public function getLogo(){ 
		return $this->logo;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setLogo($logo){ 
		$this->logo = $logo; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getType(){ 
		return $this->type;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setType($type){ 
		$this->type = $type; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getAppKey(){ 
		return $this->appKey;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setAppKey($appKey){ 
		$this->appKey = $appKey; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getAppSecret(){ 
		return $this->appSecret;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setAppSecret($appSecret){ 
		$this->appSecret = $appSecret; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getUrl(){ 
		return $this->url;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setUrl($url){ 
		$this->url = $url; 
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
	
}?>