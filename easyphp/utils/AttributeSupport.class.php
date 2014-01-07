<?php

/**
 * This class use to tell user that it's subclass had following functions :
 * 
 * setAttributes($attributes);
 * setAttribute($name, $value);
 * getAttribute($name);
 * getAttributeNames();
 * getAttributes();
 * hasAttribute($name);
 * clearAttribute($name);
 * clearAttributes();
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-22
 */
abstract class AttributeSupport{
	
	/**
	 * The attributes;
	 * @type Array
	 */
	protected $attributes;
	
	/**
	 * Set up the data attribute.
	 */
	public function setAttributes($attributes){
		$this->attributes = $attributes;
	}
	
	/**
	 * Set a attribute to this.
	 * @param string $name	The name of attribute.
	 * @param any $value The value of attribute.
	 */
	public function setAttribute($name, $value){
		$this->attributes[$name] = $value;
		return $this;
	}
	
	/**
	 * Get a attribute value from this.
	 * @param string $name The name of attribute which you want to get.
	 */
	public function getAttribute($name){
		return $this->attributes[$name];
	}
	
	/**
	 * Get all attribute name of this . 
	 * @return Array A array contains all the name of attributes.
	 */
	public function getAttributeNames(){
		$names = array();
		foreach($this->attributes as $name=>$value){
			$names[] = $name;
		}
		return $names;
	}
	
	/**
	 * Get all attributes.
	 * @return Array A array contains attributes.
	 */
	public function getAttributes(){
		return $this->attributes;
	}
	
	/**
	 * This is contains the attribute or not.
	 * @param string $name	The name of attribute.
	 */
	public function hasAttribute($name){
		return isset($this->attributes[$name])? true:false;
	}
	
	/**
	 * Delete a attribute from this.
	 * @param string $name	The name of attribute.
	 */
	public function clearAttribute($name){
		unset($this->attributes[$name]);
	}
	
	/**
	 *  Delete all attribute from this.
	 */
	public function clearAttributes(){
		unset($this->attributes);
		$this->setAttributes(array());
	}
}