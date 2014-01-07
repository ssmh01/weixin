<?php

/** 
 * 模型验证监听器，用于验证失败时直接显示消息。
 * @author blueyb.java@gmail.com
 */
class ShowMessageValidateListener implements ModelValidateListener {
	
	/**
	 * 
	 * @param  ModelValidateEvent $event
	  
	 * @see ModelValidateListener::beforeValidate()
	 */
	public function beforeValidate(ModelValidateEvent $event) {
		//DO NOT THINGS
	}
	
	/**
	 * 
	 * @param  ModelValidateEvent $event
	  
	 * @see ModelValidateListener::afterValidate()
	 */
	public function afterValidate(ModelValidateEvent $event) {
		$message = $event->getMessage();
		$message && show_message($message);
	}
}

?>