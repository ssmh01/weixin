<?php

/**
 * URL的正则过滤器,用来针对某类型URL进行过滤
 * @author blueyb.java@gmail.com
 */
class UrlRegexFilter {

	/**
	 * 要URL排除的URL正则模式
	 * @var string
	 */
	private $excludeRegex;
	
	/**
	 * 要包含的URL正则模式
	 * @var string
	 */
	private $containRegex;
	
	/**
	 * @return the $excludeRegex
	 */
	public function getExcludeRegex() {
		return $this->excludeRegex;
	}

	/**
	 * @param string $excludeRegex
	 */
	public function setExcludeRegex($excludeRegex) {
		$this->excludeRegex = $excludeRegex;
	}

	/**
	 * @return the $containRegex
	 */
	public function getContainRegex() {
		return $this->containRegex;
	}

	/**
	 * @param string $containRegex
	 */
	public function setContainRegex($containRegex) {
		$this->containRegex = $containRegex;
	}

	/**
	 * 对URL进行过滤
	 * @param string $url
	 * @return boolean 如果URL符合返回true, 否则返回false
	 */
	public function filte($url){
		//在要排除的URL正则模式里
		if($this->excludeRegex && preg_match('/' . $this->excludeRegex . '/i', $url) === 1) return false;
		$request = R::getRequest();
		//不要要包含的URL正则模式里
		if($this->containRegex && preg_match('/' . $this->containRegex . '/i', $url) != 1) return false;
		return true;
	}
}

?>