<?php
/**
 * 邮件模板
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class EmailTemplate extends DynamicModelTransformSupport{
	
	/**
	 * 配置名称
	 * @var int
	 */
	private $id;

	/**
	 * 名称 
	 * @var string 
	 */
	private $name;
	
	/**
	 * 邮件主题
	 * @var string
	 */
	private $subject;

	/**
	 * 键 
	 * @var string 
	 */
	private $key;

	/**
	 * 值 
	 * @var string 
	 */
	private $value;
	
	/**
	 *　描述
	 * @var string
	 */
	private $description;
	
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
	public function getSubject(){
		return $this->subject;
	}
	
	/**
	 *
	 * @param string
	 */
	public function setSubject($subject){
		$this->subject = $subject;
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
	 * @return the $description
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * @param string $description
	 */
	public function setDescription($description){
		$this->description = $description;
	}
	
}?>