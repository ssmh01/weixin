<?php

/**
 * 一个Web请求的生命周期监听器
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-2-22
 */
interface WebLifeTimeListener {
	
	/**
	 * 该访求在包机制启动后HttpReqeust对象初始化前被调用
	 */
	public function beforeRequestInit();
	
	/**
	 * 该访求在HttpReqeust对象初始化后被调用
	 */
	public function afterRequestInit();
	
	/**
	 * 该方法在视图显示方法被调用前调用
	 */
	public function beforeViewShow();

	/**
	 * 该方法在视图显示方法被调用后调用
	 */
	public function afterViewShow();
}

?>