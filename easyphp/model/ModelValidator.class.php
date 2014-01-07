<?php

/** 
 * 模型验证类,支持下面的验证：
 * 1.正则匹配
 * 2.比较验证(比如密码和确认密码)
 * 3.格式验证(支持email,url,currency,number,zip,integer,double,english)
 * 4.长度验证
 * 5.值验证(支持in,eq,neq,bt,lt,bw)
 * 6.必需验证(required)
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-02-14
 *
 */
class ModelValidator {
	
	/**
	 * 验证规则
	 * @var array
	 */
	private $rules;
	
	/**
	 * 被验证的模型
	 */
	private $model;
	
	/**
	 * 验证监听器
	 * @var ModelValidateListener
	 */
	private $listener;
	
	/**
	 * 内置规则
	 */
	private $regexs = array (
		'required' => '/.+/', 
		'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', 
		'url' => '/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/', 
		'currency' => '/^\d+(\.\d+)?$/', 
		'number' => '/^\d+$/', 
		'zip' => '/^[1-9]\d{5}$/', 
		'integer' => '/^[-\+]?\d+$/', 
		'double' => '/^[-\+]?\d+(\.\d+)?$/', 
		'english' => '/^[A-Za-z]+$/' 
	);
	
	/**
	 * 支持的值验证运算符
	 * @var array
	 */
	private $operators = array('in','eq','neq','bt','lt', 'bw');
	
	/**
	 * 对模型进行验证
	 * @param $fields 要验证的域，多个域用:分隔
	 * @return string 验证通过时没有返回值，验证失败返回失败消息
	 * 	
	 */
	public function validate($fields){		
		if(!$this->rules || !$this->model)return;
		if(!$fields){
			//验证规则里的所有的域
			$fields = array_keys($this->rules);
		}else{
			//确保要检验的域和规则里的对应
			$fields = explode(':', $fields);
			foreach($fields as $key=>$field){
				if(!key_exists($field, $this->rules)){
					//去除规则中不包含的域
					unset($fields[$key]);
				}
			}
		}
		if($this->listener){
			//调用监听器
			$event = new ModelValidateEvent($this);
			$event->setRules($this->rules);
			$event->setModel($this->model);
			$this->listener->beforeValidate($event);
		}
		$pass = true;
		$validateMethod = null;
		$message = null;
		foreach($fields as $field){
			$message = $this->fieldValidates($field);
			if($message){
				//验证不通过
				break;
			}
		}
		if($this->listener){
			//调用监听器
			$event = new ModelValidateEvent($this);
			$event->setRules($this->rules);
			$event->setModel($this->model);
			$event->setMessage($message);
			$this->listener->afterValidate($event);
		}
		return $message;
	}
	
	/**
	 * @return the $rules
	 */
	public function getRules() {
		return $this->rules;
	}

	/**
	 * @param array $rules
	 */
	public function setRules($rules) {
		$this->rules = $rules;
		return $this;
	}

	/**
	 * @return the $model
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * @param field_type $model
	 */
	public function setModel($model) {
		$this->model = $model;
		return $this;
	}
	
	/**
	 * @return the $listener
	 */
	public function getListener() {
		return $this->listener;
	}

	/**
	 * @param ModelValidateListener $listener
	 */
	public function setListener($listener) {
		$this->listener = $listener;
		return $this;
	}
	
	/**
	 * 验证一个域
	 * @param string $field
	 * @return 如果通过则不返回值，没有通过就返回验证失败消息
	 */
	private function fieldValidates($field){
		$rules = $this->rules[$field];
		$message = null;
		if($this->isRuleArray($rules)){
			//一个域有多个规则
			foreach($rules as $rule){
				$message = $this->fieldValidate($field, $rule);
				if($message)break;
			}
		}else{
			//只有一个规则
			$message = $this->fieldValidate($field, $rules);
		}
		return $message;
	}
	
	/**
	 * 验证一个域的一个规则
	 * @param string $field
	 * @param array $rule
	 * @return 如果通过则不返回值，没有通过就返回验证失败消息
	 */
	private function fieldValidate($field, $rule){
		$message = null;
		switch($rule['type']){
			case 'required':
				$pass = $this->requiredValidate($field, $rule, $this->model);
				break;
			case 'format':
				$pass = $this->formatValidate($field, $rule, $this->model);
				break;
			case 'length':
				$pass = $this->lengthValidate($field, $rule, $this->model);
				break;
			case 'regex':
				$pass = $this->regexValidate($field, $rule, $this->model);
				break;
			case 'value':
				$pass = $this->valueValidate($field, $rule, $this->model);
				break;
			case 'compare':
				$pass = $this->compareValidate($field, $rule, $this->model);
				break;
			default:
				$pass = true;
				break;
		}
		if(!$pass){
			//验证不通过
			$message = $rule['message']?$rule['message']:"{$field}没有通过验证";
		}
		return $message;
	}
	
	/**
	 * 检查是一个规则还是规则数组
	 * @param $rules
	 * @return 如果是规则数组则返回true
	 */
	private function isRuleArray($rules){
		foreach($rules as $rule){
			if(is_array($rule)){
				return true;
			}
			return false;
		}
	}

	/**
	 * 正则匹配规则
	 * @param array $rule
	 * @param Model $model
	 * @return boolean
	 */
	private function regexValidate($attributeName, $rule, $model) {
		if(empty($attributeName) || empty($rule['regex']))return true;
		$regex = "/{$rule['regex']}/";
		return preg_match($regex, $model->$attributeName)===1;
	}
	
	/**
	 * 比较验证
	 * @param array $rule
	 * @param Model $model
	 * @return boolean
	 */
	private function compareValidate($attributeName, $rule, $model) {
		if(empty($attributeName) || empty($rule['compareTo']))return true;
		return $model->$attributeName == $model->$rule['compareTo'];
	}
	
	/**
	 * 格式验证
	 * @param array $rule
	 * @param Model $model
	 * @return boolean
	 */
	private function formatValidate($attributeName, $rule, $model) {
		if(empty($attributeName) || !isset($this->regexs[$rule['format']]))return true;
		return preg_match($this->regexs[$rule['format']], $model->$attributeName)===1;
	}
	
	/**
	 * 长度验证
	 * @param array $rule
	 * @param Model $model
	 * @return boolean
	 */
	private function lengthValidate($attributeName, $rule, $model) {
		if(empty($attributeName) || (!isset($rule['min']) && !isset($rule['max'])) ) return true;
		$length = strlen($model->$attributeName);
		if(isset($rule['min']) && $length < $rule['min'])return false;
		if(isset($rule['max']) && $length > $rule['max'])return false;
		return true;
	}
	
	/**
	 * 值验证
	 * @param array $rule
	 * @param Model $model
	 * @return boolean
	 */
	private function valueValidate($attributeName, $rule, $model) {
		if(empty($attributeName) || !in_array($rule['operator'], $this->operators)) return true;
		switch ($rule['operator']) {
			case 'bw':
				//在min和max中，包含min和max
				return $rule['min'] <= $model->$attributeName && $model->$attributeName <= $rule['max'];
			case 'bt':
				//大于
				return $model->$attributeName > $rule['value'];
				break;
			case 'lt':
				//小于
				return $model->$attributeName < $rule['value'];
				break;
			case 'eq':
				//等于
				return $model->$attributeName == $rule['value'];
				break;
			case 'neq':
				//不等于
				return $model->$attributeName != $rule['value'];
				break;
			case 'in':
				//包含
				$values = explode(',', $rule['value']);
				return in_array($model->$attributeName, $values);
				break;
			default:
				return true;
			break;
		}
	}
	
	/**
	 * 必需验证
	 * @param array $rule
	 * @param Model $model
	 * @return boolean
	 */
	private function requiredValidate($attributeName, $rule, $model) {
		if(empty($attributeName))return true;
		return preg_match($this->regexs['required'], $model->$attributeName)===1; 
	}
}
?>