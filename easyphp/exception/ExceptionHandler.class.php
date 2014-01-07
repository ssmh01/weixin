<?php

/**
 * This class use to handle the framework exception.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-21
 */
abstract class ExceptionHander{
	
	/**
	 * Handle the exception.
	 * @param HttpRequest $request
	 * @param EasyException $exception
	 */
	public abstract function handle($request, $exception);
} 