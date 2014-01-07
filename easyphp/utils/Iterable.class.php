<?php

/**
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-24
 */

interface Iterable{
	
	/**
	 * Has next element or not.
	 * @return boolean	
	 * 	If has next element return true, else return false.
	 */
	public function hasNext();
	
	/**
	 * Get the next element.
	 * @return any
	 */
	public function next();
	
	/**
	 * Reset the iterator.
	 */
	public function reset();
}