<?php

/** 
 * 上下文匹配器，从URL的上下文中匹配Action
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-02-17
 */
class ContextMatcher extends ActionMatcher {
	
	/**
	 * 上下文分隔符
	 * @var string
	 */
	const CONTEXT_SEPARATOR = '/';
	
	private $urlRegexFilter = null;
	
	/**
	 * 构造函数
	 * @param array $params
	 * 匹配器的参数array('excludeRegex'=>'', 'containRegex'=>'');
	 */
	public function __construct($params){
		//把参数安装到匹配器
		BeanUtils::install($this, $params);
		$this->urlRegexFilter = new UrlRegexFilter();
	}
	
	/* 
	 * @see ActionMatcher::matchs()
	 */
	public function matchs(HttpRequest $request, ActionMapping $mapping) {
		if(!$this->filte($request->getRequestURI())) return false;
		$context = trim($request->getContext(), self::CONTEXT_SEPARATOR);
		$contexts = explode(self::CONTEXT_SEPARATOR, $context);

		if($this->getModule()){
			//如果指定了默认的模块
			$count = count($contexts);
			if($count < 1) return false;	//长度小于1说明没有指定Action
			if($count > 2){
				//取上下文数组的后面2个
				$contexts = array_slice($contexts, count - 2, 2);
			}
			$module = $this->getModule();
			$action = $contexts[0];
			$method = $contexts[1];
		}else{
			$count = count($contexts);
			if($count < 2) return false;	//长度不为2
			if($count > 3){
				//取上下文数组的后面3个
				$contexts = array_slice($contexts, count - 3, 3);
			}
			$module = $contexts[0];
			$action = $contexts[1];
			$method = $contexts[2];
		}

		if(!$module || !$action)return false;	//如果没指定模块或Action则返回false
		$mapping->setModule($module);
		$mapping->setAction($action);
		!$method or $mapping->setMethod($method);
		$mapping->setMatcher($this);
		return true;
	}
	
	/**
	 * @return the $excludeRegex
	 */
	public function getExcludeRegex() {
		return $this->urlRegexFilter->getExcludeRegex();
	}

	/**
	 * @param string $excludeRegex
	 */
	public function setExcludeRegex($excludeRegex) {
		$this->urlRegexFilter->setExcludeRegex($excludeRegex);
	}

	/**
	 * @return the $containRegex
	 */
	public function getContainRegex() {
		return $this->urlRegexFilter->getContainRegex();
	}

	/**
	 * @param string $containRegex
	 */
	public function setContainRegex($containRegex) {
		$this->urlRegexFilter->setContainRegex($containRegex);
	}

	/**
	 * 对URL进行过滤
	 * @param string $url
	 * @return boolean 如果URL符合返回true, 否则返回false
	 */
	public function filte($url){
		return $this->urlRegexFilter->filte($url);
	}
}

?>