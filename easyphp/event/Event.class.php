<?php

/**
 * The base event of mvc framework.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-4
 */

class Event{
	
	/**
	 * The event source of event.
	 */
	protected $source;
	
	/**
	 * The data to carry.
	 * @type array
	 */
	protected $data;
	
	function __construct($source){
		$this->source = $source;
		$this->data = array();
	}
	
	public function getSource(){
		return $this->source;
	}
	
	public function setSource($source){
		$this->source = $source;
	}
	
	public function getData($key){
		return $this->data[$key];
	}
	
	public function setData($key, $value){
		$this->data[$key] = $value;
	}
}