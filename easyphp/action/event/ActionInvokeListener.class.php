<?php

/**
 * Action方法调用事件监听器
 * @see <code>Event</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-03-06
 */

 interface ActionInvokeListener{
 	
 	/**
 	 * 该方法会在Action方法调用前调用
 	 * @param ActionInvokeEvent $event
 	 * @see <code>ActionInvokeEvent</code>
 	 */
 	public function beforeInvoke(ActionInvokeEvent $event);
 	
 	/**
 	 * 该方法会在Action方法调用后调用
 	 * @param ActionInvokeEvent $event
 	 * @see <code>ActionInvokeEvent</code>
 	 */
 	public function afterInvoke(ActionInvokeEvent $event);
 }