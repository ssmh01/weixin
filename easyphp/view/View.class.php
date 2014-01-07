<?php

/**
 * This Interface represents a View use to show the response to client.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-20
 */
 
interface View{
	
	/**
	 * Show the response to the user client.
	 * @param HttpRequest $request
	 */
	public function show(HttpRequest $request);
}