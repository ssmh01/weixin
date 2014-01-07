<?php

/**
 * This interface represents a event listenner to processing the request dispatch event.
 * @see <code>DispatchEvent</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-5
 */

 interface DispatchListener{
 	
 	/**
 	 * This function will invoke before the request been dispatch. You use
 	 * intercept the request by returning a <code>Action</code> in this method.
 	 * @param DispatchEvent $event
 	 * @see <code>DispatchEvent</code>
 	 * @return Action if return a action, framework will use this action to process request.
 	 */
 	public function beforeDispatch(DispatchEvent $event);
 	
 	/**
 	 * This function will invoke after the request been dispatch.
 	 * @param DispatchEvent $event
 	 * @see <code>DispatchEvent</code>
 	 * @return Action if return a action, framework will use this action to process request.
 	 */
 	public function afterDispatch(DispatchEvent $event);
 }