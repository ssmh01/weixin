<?php

/**
 * 玩法参数选项类
 * @author blueyb.java@gmail.com
 */
class PlayWayParameterOption{
	
	/**
	 * 值范围分隔符
	 * @var string
	 */
	const RANGE_SEPARATOR = '-';
	
	/**
	 * 选项值类型:文本
	 * @var string
	 */
	const TYPE_TEXT = 'text';
	/**
	 * 选项值类型:范围
	 * @var string
	 */
	const TYPE_RANGE = 'range';
	
	/**
	 * 选项标签名
	 * @var string
	 */
	private $label;
	
	/**
	 * 选项值类型
	 * @var string
	 */
	private $type = self::TYPE_TEXT;
	
	/**
	 * 选项描述
	 * @var string
	 */
	private $description;

	/**
	 * 选项值
	 * @var mixed
	 */
	private $value;
	
	/**
	 * 当选项值类型为range时的最小值
	 * @var mixed
	 */
	private $minValue;
	
	/**
	 * 当选项值类型为range时的最大值
	 * @var mixed
	 */
	private $maxValue;
	
	/**
	 * 被选择中次数
	 * @var 
	 */
	private $playCount = 0;
	
	/**
	 * @return the $name
	 */
	public function getName() {
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
		if($this->isRangeType()){
			$rangeValue = array();
			$rangeValue[] = $this->getMinValue();
			$rangeValue[] = $this->getMaxValue();
			$this->value = implode(self::RANGE_SEPARATOR, $rangeValue);
		}
		return $this->value;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}
	
	/**
	 * @return string $type
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 * @return mixed $mixValue
	 */
	public function getMinValue(){
		return $this->minValue;
	}

	/**
	 * @return mixed $maxValue
	 */
	public function getMaxValue(){
		return $this->maxValue;
	}

	/**
	 * @param string $type
	 */
	public function setType($type){
		$this->type = $type;
	}

	/**
	 * @param mixed $mixValue
	 */
	public function setMinValue($minValue){
		$this->minValue = $minValue;
	}

	/**
	 * @param mixed $maxValue
	 */
	public function setMaxValue($maxValue){
		$this->maxValue = $maxValue;
	}
	
	/**
	 * 值类型是否是range类型
	 */
	public function isRangeType(){
		return $this->type == self::TYPE_RANGE;
	}
	
	/**
	 * @return number $playCount
	 */
	public function getPlayCount(){
		return $this->playCount;
	}

	/**
	 * @param number $playCount
	 */
	public function setPlayCount($playCount){
		$this->playCount = $playCount;
	}

	public function addPlayCount(){
		$this->playCount += 1;
	}
}
?>