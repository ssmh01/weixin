<?php

/**
 * 模型验证事件
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-02-14
 */
class ModelValidateEvent extends Event {
	
	/**
	 * @return the $model
	 */
	public function getModel() {
		return $this->data['model'];
	}

	/**
	 * @param Model $model
	 */
	public function setModel($model) {
		$this->data['model'] = $model;
	}

	/**
	 * @return the $rules
	 */
	public function getRules() {
		return $this->data['rules'];
	}

	/**
	 * @param array $rules
	 */
	public function setRules($rules) {
		$this->data['rules'] = $rules;
	}
	
	/**
	 * @return the $message
	 */
	public function getMessage() {
		return $this->data['message'];
	}

	/**
	 * @param string $message
	 */
	public function setMessage($message) {
		$this->data['message'] = $message;
	}
	
}

?>