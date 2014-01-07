<?php

/**
 * 分享服务接口
 * 
 * @author blueyb.java@gmail.com
 */
interface IShareService{
	
	/**
	 * 分享一条消息到一个站外绑定
	 * @param string $message
	 * @param array $bind
	 */
	public function share($message, $bind);
}

?>