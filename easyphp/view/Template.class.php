<?php

/**
 *	This Object represent a template file.
 *
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-17
 */
 
class Template implements View{
	
	/**
	 * Which set of this template belong to.
	 * @type <code>TemplateSet</code>
	 */
	private $templateSet;
	
	/**
	 * The file name of template.
	 * @type string
	 */
	private $name;
	
	/**
	 * The suffix name of source template file. It contain dot.
	 */
	private $suffix;
	
	/**
	 * The response content of template.
	 * @type string
	 */
	private $content;
	
	/**
	 * The template file had been compiled or not.
	 * @type boolean
	 */
	private $isCompiled;
	
	public function __construct($set, $name, $suffix){
		$this->setTemplateSet($set);
		$this->setName($name);
		$this->setSuffix($suffix);
		$this->isCompiled = false;
	}
	
	/**
	 * Set up the <code>TemplateSet</code>
	 */
	public function setTemplateSet($templateSet){
		$this->templateSet = $templateSet;
	}
	
	/**
	 * Get the <code>TemplateSet</code> of this template.
	 * @return TemplateSet
	 */
	public function getTemplateSet(){
		return $this->templateSet;
	}
	
	/**
	 * Set up the file name of template.
	 */
	public function setName($name){
		$this->name = $name;
	}
	
	/**
	 * Get the file name of template.
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Get the full name of template file. It contain the dir name and the suffix name.
	 */
	public function getFullName(){
		return  $this->templateSet->getFullName() . '/' . $this->name . $this->suffix;
	}
	
	
	/**
	 * Set up the suffix of source template file.
	 */
	public function setSuffix($suffix='.htm'){
		if(empty($suffix)){
			$suffix = '.htm';
		}
		$this->suffix = $suffix;
	}
	
	/**
	 * Get the suffix of source template file.
	 */
	public function getSuffix(){
		return $this->suffix;
	}
	
	public function setContent($content){
		$this->content = $content;
	}
	
	/**
	 * Get the template content.
	 * @return string
	 */
	public function getContent(){
		return $this->content? $this->content:$this->content = file_get_contents($this->getFullName());
	}
	
	/**
	 * Set up the compile flag of this template.
	 */
	public function setCompiled($compiled=false){
		$this->isCompiled = $compiled;
	}
	
	/**
	 * Check the compile flag of this template.
	 * @return boolean
	 */
	public function isCompiled(){
		return $this->isCompiled;
	}
	
	/**
	 * The template file is exists or not.
	 */
	public function isExists(){
		return file_exists($this->getFullName());
	}
	
	/**
	 * Show the response to user client.
	 * @see <code>View::show</code>
	 */
	public function show(HttpRequest $request){
		$config = $request->getConfig();
		if($config->getConfig('debug_enable') || !TemplateUtils::exists($this)){
			$compiler = new TemplateCompiler();
			$compiler->setUp($config);
			$compiler->compile($this);
			TemplateUtils::write($this);
		}
		extract($request->getAttributes());
		include_once(TemplateUtils::getCacheFilePath($this));
	}
}