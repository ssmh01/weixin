<?php
/**
 * 配置模型
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class Config extends DynamicModelTransformSupport{

	/**
	 * 配置名称 
	 * @var int 
	 */
	private $id;

	/**
	 * 配置名称 
	 * @var string 
	 */
	private $name;

	/**
	 * 所属选项卡 
	 * @var string 
	 */
	private $tab;

	/**
	 * 该配置的类型，text，文本输入框；password，密码输入框；textarea，文本区域；select，下拉框单选；checkbox, 
	 * @var string 
	 */
	private $type;

	/**
	 * 可选值,只有type字段为select,options时才有值, 
	 * @var string 
	 */
	private $options;

	/**
	 * 配置键 
	 * @var string 
	 */
	private $key;

	/**
	 * 配置值 
	 * @var string 
	 */
	private $value;

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
	 * @return string 
	 */
	public function getTab(){ 
		return $this->tab;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setTab($tab){ 
		$this->tab = $tab; 
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
	public function getOptions(){ 
		return $this->options;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setOptions($options){ 
		$this->options = $options; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getKey(){ 
		return $this->key;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setKey($key){ 
		$this->key = $key; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getValue(){ 
		return $this->value;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setValue($value){ 
		$this->value = $value; 
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