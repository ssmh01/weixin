<?php

/** 
 * 模型验证事件监听器
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-02-14
 */
interface ModelValidateListener {
	
	/**
	 * 验证前调用
	 * @param ModelValidateEvent $event
	 */
	public function beforeValidate(ModelValidateEvent $event);
	
	/**
	 * 验证后调用
	 * @param ModelValidateEvent $event
	 */
	public function afterValidate(ModelValidateEvent $event);	
}

?>