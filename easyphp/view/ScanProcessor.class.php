<?php

/**
 * This Object use to process the event produce by scanner.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-14
 * @see ScanProcessorInterface
 */
class ScanProcessor implements ScanProcessorInterface{
	
	/**
	 * The tag parser to parse itself.
	 */
	private $tagSelfParses;
	
	/**
	 * The tag parser to parse itself.
	 */
	private $tagSelfParseClass;
	
	/**
	 * The content after compiling.
	 */
	private $content;
	
	/**
	 * @see ScanProcessorInterface::start()
	 */
	public function start(){
		$this->content = '';
		$this->initTagSelfParse();
	}
	
	/**
	 * @see ScanProcessorInterface::hold()
	 */
	public function hold($char){
		$this->content .= $char;
	}
	
	/**
	 * @see ScanProcessorInterface::startTag()
	 */
	public function startTag($tag, $parentTag){
		$tagSelfParse = $this->getTagSelfParse($tag);
		if($tagSelfParse){
			$this->content .= $this->callTagParse($tag, $tagSelfParse, 'start');
		}else{
			$e = new TagSelfParseNotFoundException("can't not found the tag self parse for tag:" . $tag->getFullName());
			$e->setTag($tag);
			throw $e;
		}
	}
	
	/**
	 * @see ScanProcessorInterface::endTag()
	 */
	public function endTag($tag, $parentTag){
		$tagSelfParse = $this->getTagSelfParse($tag);
		if($tagSelfParse){
			$this->content .= $this->callTagParse($tag, $tagSelfParse, 'end');
		}else{
			$e = new TagSelfParseNotFoundException("can't not found the tag self parse for tag:" . $tag->getFullName());
			$e->setTag($tag);
			throw $e;
		}
	}
	
	public function getContent(){
		return $this->content;
	}
	
	/**
	 * @see ScanProcessorInterface::end()
	 */
	public function end(){
		//Now do nothing.
	}
	
	public function initTagSelfParse(){
		//load the tag parser
		$tagPath = dirname(__FILE__) . '/tags/';
		$tagDir = @opendir($tagPath);
		$suffix = '.php';
		while(($fileName = readdir($tagDir))){
			if(String::endWith($fileName, $suffix)){
				include_once($tagPath . $fileName);
			}
		}
		//load the tag map
		$this->tagSelfParses = include(dirname(__FILE__) . '/tagmap.php');
	}
	
	public function getTagSelfParse($tag){
		$className = $this->getTagParseName($tag);
		if(!$this->tagSelfParseClass[$className]){
			if($this->tagSelfParses[$className]){
				$clazz = $this->tagSelfParses[$className];
			}else{
				$clazz = Constant::TAG_DEFULT_PARSE;
			}
			$this->tagSelfParseClass[$className] = BeanUtils::builtInstance($clazz);
		}
		return $this->tagSelfParseClass[$className];
	}
	
	private function getTagParseName($tag){
		if($tag->getNamePlace()){
			return $tag->getNamePlace();
		}
		$tagName = $tag->getName();
		if(String::startWith($tagName, '$')){
			//values tag
			return Constant::TAG_VALUE_PARSE;
		}
		return $tagName;
	}
	
	private function callTagParse($tag, $tagParse, $mode='start'){
		$methodName = $mode . ucwords($tag->getName());
		$tagParseReflection = new ReflectionClass($tagParse);
		if(!$tagParseReflection->hasMethod($methodName)){
			$methodName = $mode;
		}
		$method = $tagParseReflection->getMethod($methodName);
		try{
			return $method->invoke($tagParse, $tag);
		}catch(ReflectionException $e){
			throw new MethodInvokeException($e->getMessage());
		}
	}
}