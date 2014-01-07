<?php

/**
 * @see <code>ActionMatcher</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-24
 */
class RegexMatcher extends ActionMatcher{
	
	/**
	 * 要匹配的URL模式
	 * @var string
	 */
	private $regex;
	
	/**
	 * 模块名在匹配结果中的组数
	 * @var int
	 */
	private $moudelMatchGroup = 1;
	
	/**
	 * Action名在匹配结果中的组数
	 * @var int
	 */
	private $actionMatchGroup = 2;
	
	/**
	 * 方法名在匹配结果中的组数
	 * @var int
	 */
	private $methodMatchGroup = 3;
	
	/**
	 * 构造函数
	 * @param array $params
	 * 匹配器的参数array('regex'=>'');
	 */
	public function __construct($params){
		//把参数安装到匹配器
		BeanUtils::install($this, $params);
	}
	
	/**
	 * @see ${ActionMatcher::matchs}
	 */
	public function matchs(HttpRequest $request, ActionMapping $mapping){
		if(!$this->getRegex()) return false;
		$pattern = '/' . $this->getRegex() . '/i';
		$uri = $request->getRequestURI();
		if(!preg_match_all($pattern, $uri, $matches, PREG_SET_ORDER)) return false;	//如果不匹配则返回false
		$matches = $matches[0];
		unset($matches[0]);
		if($this->getModule()){
			//如果指定了默认的模块
			$module = $this->getModule();
		}else{
			$module = $matches[$this->getModuleMatchGroup()];
		}
		$action = $matches[$this->getActionMatchGroup()];
		$method = $matches[$this->getMethodMatchGroup()];
		if(!is_string($module) || !is_string($action)) return false;//如果没指定模块或Action则返回false
		$mapping->setModule($module);
		$mapping->setAction($action);
		!$method or $mapping->setMethod($method);
		$mapping->setMatcher($this);
		return true;
	}
	
	/**
	 * @return the $regex
	 */
	public function getRegex() {
		return $this->regex;
	}

	/**
	 * @param string $regex
	 */
	public function setRegex($regex) {
		$this->regex = $regex;
	}
	
	/**
	 * @return the $moudelMatchGroup
	 */
	public function getModuleMatchGroup() {
		return $this->moudelMatchGroup;
	}

	/**
	 * @param int $moudelMatchGroup
	 */
	public function setModuleMatchGroup($moudelMatchGroup) {
		$this->moudelMatchGroup = $moudelMatchGroup;
	}

	/**
	 * @return the $actionMatchGroup
	 */
	public function getActionMatchGroup() {
		return $this->actionMatchGroup;
	}

	/**
	 * @param int $actionMatchGroup
	 */
	public function setActionMatchGroup($actionMatchGroup) {
		$this->actionMatchGroup = $actionMatchGroup;
	}

	/**
	 * @return the $methodMatchGroup
	 */
	public function getMethodMatchGroup() {
		return $this->methodMatchGroup;
	}

	/**
	 * @param int $methodMatchGroup
	 */
	public function setMethodMatchGroup($methodMatchGroup) {
		$this->methodMatchGroup = $methodMatchGroup;
	}
}