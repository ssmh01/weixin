<?php

/**
 *This object use to scan some text to finding tag and produceing the event.
 * 
 *@author blueyb
 *@since 1.0 - 2011-3-14
 */
class TextScanner{
	
	/**
	 * the flag to tell scanner this character is the start of tag.
	 */
	private $startTag;
	
	/**
	 * the flag to tell scanner this character is the start of tag.
	 */
	private $endTag;
	
	/**
	 * the scan mode.
	 */
	private $scanMode;
	
	public function __construct(){
		$this->setStartTag('{');
		$this->setEndTag('}');
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
	
	public function setScanMode($scanMode){
		$this->scanMode = $scanMode;
	}
	
	public function getScanMode(){
		return $this->scanMode;
	}
	
	public function scan($text, ScanProcessorInterface $processor){
		if(empty($text) || empty($processor))return;
		$parentTag = null;
		$currentTag = null;
		$currentTagString = '';
		$currentChar = null;
		$nextChar = null;
		$textLen = strlen($text);
		$currentIndex = 0;
		$this->scanMode = ScannerMode::$NORMAL;
		$processor->start();
		while($currentIndex < $textLen){
			$currentChar = $text[$currentIndex];
			$nextChar = $text[$currentIndex+1];
			if($this->scanMode == ScannerMode::$NORMAL && $currentChar == $this->startTag){
				//if the character is flag of start tag
				if($this->isBlank($nextChar)){
					//is blank character
					$processor->hold($currentChar);
				}elseif($nextChar == '/'){
					//The end tag
					$this->scanMode = ScannerMode::$END_TAG;
					//skip the '/' character
					$currentIndex++;
				}else{
					//The start tag
					$this->scanMode = ScannerMode::$START_TAG;
				}
			}else if(($this->scanMode == ScannerMode::$START_TAG || $this->scanMode == ScannerMode::$END_TAG)&& $currentChar == $this->endTag){
				//if the character is flag of end tag
				$parentTag = $currentTag;
				$currentTag = Tag::parseTagFromString($currentTagString);
				//clear
				$currentTagString = '';
				//call the processor.
				if($this->scanMode == ScannerMode::$START_TAG){
					if($currentTag->isLiteralTag()){
						$this->scanMode = ScannerMode::$LITERAL;
						echo 'x';
					}else{
						$processor->startTag($currentTag, $parentTag);
					}
				}elseif($this->scanMode == ScannerMode::$END_TAG){
					if($currentTag->isLiteralTag()){
						$this->scanMode = ScannerMode::$NORMAL;
						echo 'a';
					}else{
						$processor->endTag($currentTag, $parentTag);
					}
				}
				//switch the scan mode				
				$this->scanMode = ScannerMode::$NORMAL;
			}else{
				if($this->scanMode == ScannerMode::$NORMAL){
					$processor->hold($currentChar);
				}elseif($this->scanMode == ScannerMode::$START_TAG || $this->scanMode == ScannerMode::$END_TAG){
					$currentTagString .= $currentChar;
				}
			}
			$currentIndex++;
		}
		$processor->end();
	}
	
	private function isBlank($str){
		return preg_match('/\s+/', $str);
	}
}

class ScannerMode{
	
	/**
	 * Normal scan mode, the "put()" method of event processor will been called.
	 */
	public static $NORMAL = 1;
	
	/**
	 * Tag scan mode, the "put" method of event processor will not been called.
	 */
	public static $START_TAG = 2;
	
	/**
	 * Tag scan mode, the "put" method of event processor will not been called.
	 */
	public static $END_TAG = 3;
	
	/**
	 * 字面模式，不进行任何解析
	 * @var int
	 */
	public static $LITERAL = 4;
}