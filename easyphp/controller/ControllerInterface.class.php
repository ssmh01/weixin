<?php

/**
 * This interface represents a controller to handle http request 
 * which come from client.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-20
 */
 
interface ControllerInterface{
	
	/**
	 * Distribute the http request which come from client.
	 * @param HttpRequest $request	This parameter can not be NULL.
	 * @return <code>Action</code> description
	 */
	public function requestDispatch(HttpRequest $request);
}