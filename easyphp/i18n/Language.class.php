<?php

/**
 * This object represent a util class to support mutil language.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-27
 */
class Language{
	
	/**
	 * The the root directory of language packet.
	 * @var array/string
	 */
	private $packetRoots;
	
	/**
	 * The base name of language packet.
	 */
	private $baseName;
	
	/**
	 * The language key-value.
	 */
	private $languages;
	
	public function Language($packetRoots, $baseName){
		$this->setPacketRoots($packetRoots);
		$this->setBaseName($baseName);
		$this->languages = array();
	}
	
	/**
	 * Get the root directory of language packet.
	 * @return array/string
	 */
	public function getPacketRoots(){
		return $this->packetRoots;
	}
	
	/**
	 * Set the root directory of language packet.
	 * @param string $packetRoot
	 */
	public function setPacketRoots($packetRoots){
		$this->packetRoots = $packetRoots;
	}
	
	/**
	 * Get the base name of language packet.
	 * @return string
	 */
	public function getBaseName(){
		return $this->baseName;
	}
	
	/**
	 * Set the base name of language packet.
	 * @param string $baseName
	 */
	public function setBaseName($baseName){
		$this->baseName = $baseName;
	}
	
	/**
	 * 加载语言文件
	 * @param Locale $locale
	 */
	public function loadLanguages($locale){
		$localeString = empty($locale)? '': $locale->toString();
		if(!$localeString && !$this->getBaseName()) return;
		$languageFile = '';
		$packetRoots = $this->getPacketRoots();
		if($this->getBaseName()){
			if(is_array($packetRoots)){
				//加载多个语言包
				$languages = null;
				foreach($packetRoots as $packetRoot){
					if($packetRoot){
						$languageFile = $packetRoot . $this->getBaseName();
						if($localeString){
							$languageFile .=  '_' . $localeString . '.php';
						}else{
							$languageFile .=  '.php';
						}
						$languages = include_once($languageFile);
						if($languages){
							$this->languages = array_merge($this->languages, $languages);
						}
					}
				}
			}elseif(is_string($packetRoots)){
				//只加载一个语言包
				$languageFile = $packetRoots . $this->getBaseName();
				if($localeString){
					$languageFile .=  '_' . $localeString . '.php';
				}else{
					$languageFile .=  '.php';
				}
				$this->languages = include_once($languageFile);
			}
		}else{
			if(is_array($packetRoots)){
				//加载多个语言包
				$languages = null;
				foreach($packetRoots as $packetRoot){
					if($packetRoot){
						$languageFile = $packetRoot . $localeString . '.php';
						$languages = include_once($languageFile);
						if($languages){
							$this->languages = array_merge($this->languages, $languages);
						}
					}
				}
			}elseif(is_string($packetRoots)){
				//只加载一个语言包
				$languageFile = $packetRoots . $localeString . '.php';
				$this->languages = include_once($languageFile);
			}
		}
		
	}
	
	/**
	 * Set up the language key-value.
	 * @param string $key
	 * @param string $value
	 */
	public function set($key, $value){
		$this->languages[$key] = $value;
	}
	
	/**
	 * get the language value.
	 * @param string $key
	 * @param array $values
	 * 	The array values to replace the value mark in language value.
	 */
	public function get($key, $params){
		$v = $this->languages[$key];
		if(strlen($v) == 0) return $key;
		if(!isset($params)) return $v;
		$matchs = null;
		preg_match_all("/\{(.+?)\}/", $v, $matchs);
		$froms = $tos = array();
		foreach($matchs[1] as $match){
			$froms[] = "{{$match}}";
			$tos[] = $params[$match];
		}
		return str_replace($froms, $tos, $v);
	}
}