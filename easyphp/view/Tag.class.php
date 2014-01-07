<?php

/**
 * This object represent a tag that will be parse.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-14
 */
class Tag{
	
	/**
	 *  the flag to tell scanner this character is the start of tag.
	 */
	private $startTag;
	
	/**
	 * the flag to tell scanner this character is the start of tag.
	 */
	private $endTag;
	
	/**
	 * The name place of tag.
	 */
	private $namePlace;
	
	/**
	 * The name of tag.
	 */
	private $name;
	
	/**
	 * The body of tag.
	 */
	private $body;
	
	function __construct($namePlace, $name, $body){
		$this->namePlace = $namePlace;
		$this->name = $name;
		$this->body = $body;
		$this->startTag = '{';
		$this->endTag = '}';
	}
	
	public static function parseTagFromString($tagString){
		$tag = new Tag();
		$res = preg_split("/[\s]+/", $tagString, 2, PREG_SPLIT_NO_EMPTY);
		$tag->setBody($res[1]);
		if(strpos($res[0], ':')){
			$res = explode(':', $res[0]);
			$tag->setNamePlace($res[0]);
			$tag->setName($res[1]);
		}else{
			$tag->setName($res[0]);
		}
//		Debug::println($tag->toString());
		return $tag;
	}
	
	public function setNamePlace($namePlace){
		$this->namePlace = $namePlace;
	}
	
	public function getNamePlace(){
		return $this->namePlace;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getFullName(){
		if(!empty($this->namePlace)){
			return $this->namePlace . ':' . $this->name;
		}else{
			return $this->name;
		}
	}
	
	public function setBody($body){
		$this->body = $body;
	}
	
	public function getBody(){
		return $this->body;
	}
	
	public function setStartTag($startTag){
		$this->startTag = $startTag;
	}
	
	public function getStartTag(){
		return $this->startTag;
	}
	
	public function setEndTag($endTag){
		$this->endTag = $endTag;
	}
	
	public function getEndTag(){
		return $this->endTag;
	}
	
	/**
	 * 是否是字面标签
	 * @return boolean
	 */
	public function isLiteralTag(){
		return strtolower($this->name) == Constant::TAG_NAME_LITERAL;
	}
	
	public function toString(){
		return  $this->startTag . $this->getFullName() . Constant::BLANK . $this->body . Constant::BLANK . $this->endTag;
	}
}