<?php

/**
 * This Object represent a template compiler to compile template file.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-2-14
 */

/**
 * @see <code>CompileInterface</code>
 */
class TemplateCompiler implements CompileInterface{
	
	private $scanner;
	
	private $processor;
	
	public function __construct(){}
	
	public function setScanner($scanner){
		$this->scanner = $scanner;
	}
	
	public function getScanner(){
		return $this->scanner;
	}
	
	public function setProcessor($processor){
		$this->processor = $processor;
	}
	
	public function getProcessor(){
		return $this->processor;
	}
	
	/**
	 * @see CompileInterface::setUp()
	 */
	public function setUp($config){
		//the $conifg must be EasyConfig
		$scanner = new TextScanner();
		$scanner->setStartTag($config->getConfig('view_starttag'));
		$scanner->setEndTag($config->getConfig('view_endtag'));
		$this->setScanner($scanner);
		$processor = new ScanProcessor();
		$this->setProcessor($processor);
	}
	
	/**
	 * @see <code>CompileInterface::compile</code>
	 */
	public function compile(Template $template){
		if(empty($this->scanner) || empty($this->processor)) return;
		if(!$template->isExists()){
			$e = new TemplateNotFoundException("Template[{$template->getFullName()}] not found on this uri.");
			$e->setTemplate($template);
			throw $e;
		}
		$this->scanner->scan($template->getContent(), $this->processor);
		$template->setContent($this->processor->getContent());
		$template->setCompiled(true);
	}
}