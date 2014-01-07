<?php

/**
 * 参数匹配器，通过参数来进行匹配
 * @see <code>ActionMatcher</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-24
 */
class ParameterMatcher extends ActionMatcher{
	
	/**
	 * 模块参数名称
	 * @var string
	 */
	private $moduleParameterName = 'mod';
	
	/**
	 * Action参数名称
	 * @var string
	 */
	private $actionParameterName = 'act';
	
	/**
	 * 方法参数名称
	 * @var string
	 */
	private $methodParameterName = 'met';
	
	private $urlRegexFilter = null;
	
	/**
	 * 构造函数
	 * @param array $params
	 * 匹配器的参数array('moduleParameterName'=>'mod', 'actionParameterName'=>'act', 'methodParameterName'=>'met');
	 */
	public function __construct($params){
		//把参数安装到匹配器
		BeanUtils::install($this, $params);
		$this->urlRegexFilter = new UrlRegexFilter();
	}
	
	/**
	 * @return the $moduleParameterName
	 */
	public function getModuleParameterName() {
		return $this->moduleParameterName;
	}

	/**
	 * @param string $moduleParameterName
	 */
	public function setModuleParameterName($moduleParameterName) {
		$this->moduleParameterName = $moduleParameterName;
	}

	/**
	 * @return the $actionParameterName
	 */
	public function getActionParameterName() {
		return $this->actionParameterName;
	}

	/**
	 * @param string $actionParameterName
	 */
	public function setActionParameterName($actionParameterName) {
		$this->actionParameterName = $actionParameterName;
	}

	/**
	 * @return the $methodParameterName
	 */
	public function getMethodParameterName() {
		return $this->methodParameterName;
	}

	/**
	 * @param string $methodParameterName
	 */
	public function setMethodParameterName($methodParameterName) {
		$this->methodParameterName = $methodParameterName;
	}

	/**
	 * @see ${ActionMatcher::matchs}
	 */
	public function matchs(HttpRequest $request, ActionMapping $mapping){
		if(!$this->filte($request->getRequestURI())) return false;
		if($this->getModule()){
			//如果指定了默认的模块
			$module = $this->getModule();
		}else{
			$module = $request->getParameter($this->getModuleParameterName());
		}
		$action = $request->getParameter($this->getActionParameterName());
		$method = $request->getParameter($this->getMethodParameterName());
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