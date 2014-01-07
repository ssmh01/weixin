<?php

/**
 * 玩法参数类
 * @author blueyb.java@gmail.com
 */
class PlayWayParameter{
	
	/**
	 * 参数名称
	 * @var string
	 */
	private $name;
	
	/**
	 * 参数标签名
	 * @var string
	 */
	private $label;
	
	/**
	 * 参数描述
	 * @var string
	 */
	private $description;
	
	/**
	 * @var array
	 */
	private $options = array();

	/**
	 * 参数值
	 * @var mixed
	 */
	private $value;
	
	const NAME_CUSTOM = 'c';
	
	/**
	 * @return the $name
	 */
	public function getName() {
		if(!$this->name){
			$this->name = self::NAME_CUSTOM;
		}
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return the $label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param string $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return the $value
	 */
	public function getValue() {
		/*
		if(!$this->value){
			//默认值
			$option = $this->getFirstOption();
			if($option){
				$this->value = $option->getValue();
			}
		}
		*/
		return $this->value;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}
	
	/**
	 * @return the $options
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param multitype: $options
	 */
	public function setOptions($options) {
		$this->options = $options;
	}
	
	private function getFirstOption(){
		reset($this->options);
		return current($this->options);
	}
	
	public function addOption(PlayWayParameterOption $option){
		$this->options[$option->getValue()] = $option;
	}
	
	public function addPlayCount($option){
		if($this->options[$option] instanceof PlayWayParameterOption) {
			$this->options[$option]->addPlayCount();
		}
	}
	
	public function getChooseOption(){
		return $this->options[$this->value];
	}
	
	public function isEmptyValue(){
		return (!isset($this->value) || $this->value == '');
	}
}
?>