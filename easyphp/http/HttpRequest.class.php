<?php

/**
 * This Object represents a http request which from user client.
 * It contains all the value of parameters and so on
 * @since 1.0 - 2010-12-26
 */
final class HttpRequest extends AttributeSupport{
	
	/**
	 * The request uri.
	 * @type String
	 */
	private $requestURI;
	
	/**
	 * The HTTP request method used in this request.
	 * @type String
	 */
	private $method;
	
	/**
	 * The http protocol.
	 */
	private $protocol;
	
	/**
	 * The header from client request.
	 * @private
	 * @type array
	 */
	private $headers;
	
	/**
	 * The Http Referer url
	 * @var string
	 */
	private $referer;
	
	/**
	 * All the parameters(contains $_GET, $_POST) from client request.
	 * @private
	 * @type array
	 */
	private $parameters;
	
	/**
	 * The file parameters from client.
	 */
	private $files;
	
	/**
	 * The context path of this request.
	 * @private
	 * @type string
	 */
	private $context;
	
	/**
	 * 请求时间戳
	 * @var int
	 */
	private $requestTime;
	
	/**
	 * 配置
	 * @var EasyConfig
	 */
	private $config;

	/**
	 * 处理这个请求的Action
	 * @var Action
	 */
	private $action;
	
	/**
	 * 这个请求返回的视图
	 * @var Template
	 */
	private $view;
	
	/**
	 * The construct method
	 */
	function __construct(){
		$this->parameters  = array();
		$this->headers = array();
		$this->files  = $_FILES;
		$this->requestTime = time();
	}
	
	/**
	 * Set up the request uri.
	 * @param string $url The uri of request.
	 */
	public function setRequestURI($uri){
		$this->requestURI = $uri;
		return $this;
	}
	
	/**
	 * Get the request uri.
	 * @return string
	 */
	public function getRequestURI(){
		return $this->requestURI;
	}
	
	/**
	 * Set up the request method.
	 * @param string $method
	 */
	public function setMethod($method){
		$this->method = $method;
		return $this;
	}
	
	/**
	 * Get the request method.
	 * @return string
	 */
	public function getMethod(){
		return $this->method;
	}
	
	public function isPost(){
		return strtolower($this->method) == 'post';
	}
	
	/**
	 * Set up the request protocol.
	 * @param string $protocol
	 */
	public function setProtocol($protocol){
		$this->protocol = $protocol;
		return $this;
	}
	
	/**
	 * Get the request protocol.
	 * @return string
	 */
	public function getProtocol(){
		return $this->protocol;
	}
	
	/**
	 * Set set the request header.
	 * @param array $headers A array contains request header names and values.
	 */
	public function setHeaders(Array $headers){
		$this->headers = $headers;
		return $this;
	}
	
	/**
	 * Add a request header to request.
	 * @param string $name	The name of request header.
	 * @param any $value The value of request header.
	 */
	public function addHeader($name, $value){
		$this->headers[$name] = $value;
		return $this;
	}
	
	/**
	 * Get all the request header
	 * @return array
	 */
	public function getHeaders(){
		return $this->headers;
	}
	
	/**
	 * Get one request header.
	 * @param string $name	The name of request header.
	 */
	public function getHeader($name){
		return $this->headers[$name];
	}
	
	/**
	 * @return the $referer
	 */
	public function getReferer() {
		return $this->referer;
	}

	/**
	 * @param string $referer
	 */
	public function setReferer($referer) {
		$this->referer = $referer;
	}

	/**
	 * Set up the parameters.
	 * @param array $parameters
	 */
	public function setParameters(Array $parameters){
		$this->parameters = $parameters;
		return $this;
	}
	
	/**
	 * 添加一个参数
	 * @param string $name
	 * @param mixed $value
	 */
	public function setParameter($name, $value){
		$this->parameters[$name] = $value;
		return $this;
	}
	
	/**
	 * Get all parameters.
	 * @return array
	 */
	public function getParameters(){
		return $this->parameters;
	}
	
	/**
	 * Add a parameter into parameter container.
 	 * @param string $name	The name of parameter.
	 * @param any $value The value of parameter.
	 */
	public function addParameter($name, $value){
		$this->parameters[$name] = $value;
		return $this;
	}
	
	/**
	 * Get a parameter's value.
	 * @param string $name
	 */
	public function getParameter($name){
		return $this->parameters[$name];
	}
	
	/**
	 * Get all Parameter name of this request. 
	 * @return Array A array contains all the name of parameters.
	 */
	public function getParameterNames(){
		$names = array();
		foreach($this->parameters as $name=>$value){
			$names[] = $name;
		}
		return $names;
	}
	
	/**
	 * This request is contains the parameter or not.
	 * @param string $name	The name of Parameter.
	 */
	public function hasParameter($name){
		return isset($this->parameters[$name])? true:false;
	}
	
	/**
	 * Delete a parameter from a request.
	 * @param string $name	The name of Parameter.
	 */
	public function clearParameter($name){
		unset($this->parameters[$name]);
		return $this;
	}
	
	/**
	 *  Delete all parameter from a request.
	 */
	public function clearParameters(){
		unset($this->parameters);
		$this->setParameters(array());
		return $this;
	}
	
	/**
	 * Get all file variables.
	 * @return array
	 */
	public function getFiles(){
		return $this->files;
	}
	
	/**
	 * Get a value of variable.
	 * @param string name of variable.
	 */
	public function getFile($name){
		return $this->files[$name];
	}
	
	/**
	 * 是否有上传文件
	 * @param string $fileName
	 * @return boolean　如果有则返回真，否则返回failture
	 */
	public function hasFile($fileName){
   		return $this->files[$fileName]['size']?true:false;
	}
	
	/**
	 * 获取请求时间戳
	 * @return int
	 */
	public function getRequestTime(){
		return $this->requestTime;
	}
	
	/**
	 * Set up the context to request.
	 * @param string $context
	 */
	public function setContext($context){
		$this->context = $context;
		return $this;
	}
	
	/**
	 * Get the context from request.
	 * @return string 
	 */
	public function getContext(){
		return $this->context;
	}
	
	/**
	 * @return EasyConfig $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param EasyConfig $config
	 */
	public function setConfig(EasyConfig $config) {
		$this->config = $config;
		return $this;
	}
	
	/**
	 * @return the $action
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * @param Action $action
	 */
	public function setAction(Action $action) {
		$this->action = $action;
		return $this;
	}
	
	/**
	 * @return the $view
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * @param Template $view
	 */
	public function setView($view) {
		$this->view = $view;
		return $this;
	}
	
	/**
	 * Set a attribute to this.
	 * @param string $name	The name of attribute.
	 * @param any $value The value of attribute.
	 */
	public function assign($name, $value){
		$this->attributes[$name] = $value;
		return $this;
	}
	
	/**
	 * 跳转到任何URL地址, 跳转后浏览器地址栏发生变化
	 * @param string $url URL地址
	 */
	public function redirect($url){
		header("Location: {$url}");
		die();
	}
	
	/**
	 * 请求转发，只能转发到当前主机下，转发后浏览器地址栏不会发生变化。
	 * @param string $module
	 * @param string $action
	 * @param string $method
	 */
	public function forward($module, $action, $method){
		$actionMapping = new ActionMapping();
		$actionMapping->setModule($module);
		$actionMapping->setAction($action);
		$actionMapping->setMethod($method);
		$action = R::getAction($actionMapping);
		$this->setAction($action);
		//调用Action
		$actionInvoker = BeanUtils::builtInstance($this->getConfig()->getConfig('base_action_invoker'));
        $actionInvoker->invoke($action, $this);

		$view = TemplateUtils::createView($action->getView());
		R::setTemplate($view);
		$view->show($this);
		die();
	}
}