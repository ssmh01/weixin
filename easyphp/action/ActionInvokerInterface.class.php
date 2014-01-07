<?php

/**
 * This interface used to invoke a action, you can implements it to
 * decide how to invoke the action.
 *  
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-5
 */

interface ActionInvokerInterface{
	
	/**
	 * Invoke the method of action base on the ActionMapping,
	 * The ActionMapping is belong the action, you can call 
	 * <code>Action::getActionMapping</code> to get it.
	 * @param Action $action
	 * 	The Action Instance you want to invoke.
	 * @param HttpReqeust $request
	 * 	The http request from client.
	 */
	public function invoke(Action $action, HttpRequest $request);
}