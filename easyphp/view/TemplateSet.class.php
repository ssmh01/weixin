<?php

/**
 * This Object represent a set of template files. It intention to support
 * the multi templates function. If you have more than one set of template,
 * you can you the one you want by setting the mvc configure item named 
 * "template_set" , this
 *
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-02-14
 */
 
class TemplateSet{
	
	/**
	 * The root dir of all template sets. It must use the absolution path.
	 * @type string
	 */
	private $templateDir;
	
	/**
	 * The name of template set, it must as the same as the
	 * real dir name that local this template set on disk.
	 */
	private $templateName;
	
	function __construct($templateDir, $templateName){
		$this->templateDir = $templateDir;
		$this->templateName = $templateName;
	}
	
	/**
	 * Set up the root dir of all template sets.
	 */
	public function setTemplateDir($templateDir){
		$this->templateDir = $templateDir;
	}
	
	/**
	 * Get the root dir of all template sets.
	 * @return string
	 */
	public function getTemplateDir(){
		return $this->templateDir;
	}
	
	/**
	 * Set up the name of template set.
	 */
	public function setTemplateName($templateName){
		$this->templateName = $templateName;
	}
	
	/**
	 * Get the name of template set.
	 * @return string
	 */
	public function getTemplateName(){
		return $this->templateName;
	}
	
	/**
	 * Get the full dir name of this template set.
	 * @return string
	 */
	public function getFullName(){
		return $this->templateDir . $this->templateName . DIRECTORY_SEPARATOR;
	}
	
	public function newTemplate($name, $suffix='.htm'){
		$template = new Template($this, $name, $suffix);
		return $template;
	}
}