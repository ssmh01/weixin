<?php

/**
 * 创建动态模型，加载模型配置
 * @param string $name 模型的名称
 * @param boolean $loadConfig 是否加载配置，默认加载
 */
function M($name, $loadConfig=true){
	$model = Model::newModel($name);
	if($loadConfig){
		$model->setConfig(R::getModelConfig($model));
	}
	return $model;
}

/**
 * 创建模型数据访问对象
 * @param string/Model $model
 * @return ModelDao
 */
function MD($model){
	return ModelDao::newModelDao($model);
}

/**
 * 显示消息
 * @param string $message 消息或在语言文件里的键
 * @param string $redirect　显示消息后的转跳地址,-1表示返回上页
 * @param array $params　消息参数
 */
function show_message($message, $redirect='-1', $params=null){
	$request = R::getRequest();
	if($request->getParameter('inajax')){
		die($message);
	}
	$messageActionConfig = R::getConfig()->getConfig('base_message_action');
	if(empty($messageActionConfig)){
		die("请先配置base_message_action项");
	}
	$message = get_lang($message, $params);
	
	$request->setAttribute('redirect', $redirect);
	$request->setAttribute('message', $message);
	$request->forward($messageActionConfig['module'], $messageActionConfig['action'], $messageActionConfig['method']);
}

/**
 * 
 * @param int $total	总条目数
 * @param int $perpage	每页显示的条目数
 * @param int $page	当前页
 * @param string $url 分页的链接，如果不指定则使用当前的请求URL
 */
function multi_page($total, $perpage, $page, $url, $pageClass){
	$page = new Page($total, $perpage, $page, $url);
	$page->setPageCss($pageClass);
	return $page->generatePages();
}

/**
 * 获取模块绝对路径
 * @param string $module_name
 */
function get_module_dir($module_name){
	$easyConfig = R::getConfig();
	return $easyConfig->getConfig('base_modules_root') . $module_name . DIRECTORY_SEPARATOR;
}

/**
 * 获取浏览器语言
 */
function get_client_language(){
	$langs = preg_split('/[,;]/', $_SERVER['HTTP_ACCEPT_LANGUAGE'], 2);
	return $langs[0];
}

function get_lang($key, $params=null){
	$language = R::getLanguage();
	return $language->get($key, $params);
}

/**
 * get config value from EasyConfig
 * @param string $key
 */
function get_config($key){
	if(!is_string($key)) {
		return null;
	}
	$easyConfig = R::getConfig();
	return $easyConfig->getConfig($key);
}

/**
 * 获取请求属性
 * @param string $key
 */
function get_request_attribute($key){
	if(!is_string($key)) {
		return null;
	}
	$request = R::getRequest();
	return $request->getAttribute($key);
}

/**
 * get attribute value from HttpSession
 * @param string $key
 */
function get_session($key){
	if(!is_string($key)) {
		return null;
	}
	Init::sessionInit();
	return HttpSession::get($key);
}

/**
 * get attribute value from HttpCookie
 * @param string $key
 */
function get_cookie($key){
	if(!is_string($key)) {
		return null;
	}
	Init::cookieInit();
	return HttpCookie::get($key);
}

/**
 * 引入类或包或普通文件
 * @param $path
 */
function import($path){
    $packet = R::getPacket();
	return $packet->import($path);
}

/**
 * 根据配置对URL进行处理
 * @param string $url 请求URL
 */
function url($url){
	$isStatic = R::getConfig()->getConfig('base_url_static');
	if($isStatic){
		//静态化
		$urlPseudoStatic = R::getUrlPseudoStatic();
		return $urlPseudoStatic->pseudoStatic($url);
	}
	return $url;
}

/**
 * 把伪静态URL转换成动态URL
 * @param string $url 如果不指定则使用当前URI
 */
function dynamicUrl($url){
	if(empty($url)){
		$url = $_SERVER['REQUEST_URI'];
	}
	$urlPseudoStatic = R::getUrlPseudoStatic();
	return $urlPseudoStatic->dynamicUrl($url);
}


/**
 * 获取当前的毫秒
 * @return int
 */
function get_microtime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}


/**
 * 获取缓存
 * @param string $key
 */
function cache_get($key){
	return R::getCache()->getCache($key);
}

/**
 * 设置缓存
 * @param string $key
 * @param mixed $value 如果为空，则缓存数据从数据来源类里面取
 * @param int $lifetime 缓存生命周期，单位为秒,0为永不过期
 */
function cache_set($key, $value=null, $lifetime=0){
	return R::getCache()->updateCache($key, $value, $lifetime);
}

/**
 * 显示ajax消息
 * @param string $message 消息
 * @param string $redirect 转向地址
 * @param int $timeout 转向时间
 * @param string $tpl 指定消息模块
 */
function show_ajax_message($message, $redirect=null, $timeout=2, $tpl=null){
	die($message);
}