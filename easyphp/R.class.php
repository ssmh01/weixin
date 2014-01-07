<?php

/**
 * This object use to manage the resource(object, file, source and so on).
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-23
 */
abstract class R{
	
	/**
	 * A array to keep object.
	 */
	private static $objects;
	
	/**
	 * Get EasyConfig
	 */
	public static function getConfig(){
		return R::$objects['config'];
	}
	
	/**
	 * Set EasyConfig
	 * @param EasyConfig $config
	 */
	public static function setConfig($config){
		R::$objects['config'] = $config;
	}
	
	/**
	 * 设置包
	 */
	public static function getPacket(){
		return R::$objects['packet'];
	}
	
	public static function setPacket($packet){
		R::$objects['packet'] = $packet;
	}
	
	/**
	 * Get HttpRequest
	 * @return HttpRequest
	 */
	public static function getRequest(){
		if(!R::$objects['request']){
			R::$objects['request'] = Init::requestInit();
		}
		return R::$objects['request'];
	}
	
	/**
	 * 获取当前的视图模板
	 */
	public static function getTemplate(){
		return R::$objects['template'];
	}
	
	/**
	 * Set Template
	 * @param Template $template
	 */
	public static function setTemplate($template){
		R::$objects['template'] = $template;
	}
	
	/**
	 * Get Language
	 */
	public static function getLanguage(){
		if(!R::$objects['language']){
			$language = Init::languageInit();
			R::$objects['language'] = $language;
		}
		return R::$objects['language'];
	}
	
	/**
	 * 获取日志操作类
	 */
	public static function getLog(){
		if(!R::$objects['log']){
			R::$objects['log'] = Init::logInit();
		}
		return R::$objects['log'];
	}
	
	/**
	 * 获取缓存操作类
	 */
	public static function getCache(){
		if(!R::$objects['cache']){
			R::$objects['cache'] = Init::cacheInit();
		}
		return R::$objects['cache'];
	}
	
	/**
	 * 获取数据库访问类
	 * @return DB
	 */
	public static function getDB(){
		if(!R::$objects['db']){
			R::$objects['db'] = Init::dbInit();
		}
		return R::$objects['db'];
	}
	
	public static function getActionMapping(){
		return R::$objects['action_mapping'];
	}
	
	/**
	 * 获取ActionMapping对应的Action
	 * @param ActionMapping $mapping
	 */
	public static function getAction(ActionMapping $mapping){
		R::$objects['action_mapping'] = $mapping;
		
		$actionId = 'action_' . $mapping->getModule() .'_' . $mapping->getAction();
		if(R::$objects[$actionId]){
            R::$objects[$actionId]->setActionMapping($mapping);
			return R::$objects[$actionId];
		}
		$action = Init::actionInit($mapping);
		R::$objects[$actionId] = $action;
		return $action;
	}
	
	/**
	 * 获取模型的配置
	 * @param string/Model $model
	 */
	public static function getModelConfig($model){
		if($model instanceof Model){
			if($model->getConfig()){
				return $model->getConfig();
			}
			$model = $model->getModelName();
		}
		$easyConfig = R::getConfig();
		$modelConfigPath = $easyConfig->getConfig('base_model_config_root');
		$modelConfigFile = $modelConfigPath . ucfirst($model). Constant::MODEL_CONFIG_SUFFIX;
		return include($modelConfigFile);
	}
	
	/**
	 * 获取当前所在的模块
	 */
	public static function getCurrentModule(){
		return R::$objects['current_module'];
	}
	
	/**
	 * 设置当前所在的模块
	 * @param Module $module
	 */
	public static function setCurrentModule($module){
		R::$objects['current_module'] = $module;
	}
	
	/**
	 * 获取Web生命周期监听器
	 * @return WebLifeTimeListener/null
	 */
	public static function getWebLifeTimeListener(){
		$easyConfig = R::getConfig();
		if(!R::$objects['webLifeTimeListener'] && $easyConfig->getConfig('event_web_lifetime_listener')){
			R::$objects['webLifeTimeListener'] = BeanUtils::builtInstance($easyConfig->getConfig('event_web_lifetime_listener'));
		}
		return R::$objects['webLifeTimeListener'];
	}
	
	/**
	 * 获取URL伪静态处理类
	 * @return UrlPseudoStatic
	 */
	public static function getUrlPseudoStatic(){
		if(!R::$objects['urlPseudoStatic']){
			R::$objects['urlPseudoStatic'] = new UrlPseudoStatic();
		}
		return R::$objects['urlPseudoStatic'];
	}
	
	/**
	 * 获取模块对外公开的服务类
	 * @param string $moduleName 模块名称
	 * @param $reflectionClass,是否只获取服务反射类
	 * @return 如果模块对外公开了服务，则返回服务类对象，否则返回空
	 */
	public static function getModuleOpenService($moduleName, $reflectionClass=false){
		$serviceClassName = ucfirst($moduleName) . Constant::MODULE_OPEN_SERVICE_CLASS_NAME_SUFFIX;
		if(R::getPacket()->classExists($serviceClassName)){
			if($reflectionClass){
				return new ReflectionClass($serviceClassName);
			}else{
				return new $serviceClassName();
			}
		}else{
			return null;
		}
	}
	
	/**
	 * 获取Action调用事件监听器
	 * @param Action $action
	 */
	public static function getActionInvokeListener($action){
		if(!($action instanceof Action)) return;
		$actionName = $action->getActionMapping()->getAction();
		if(empty($actionName) || !is_string($actionName)) return null;
		$actionName = ucfirst($actionName) . 'Action';
		$listeners = get_config('event_action_listeners');
		$listener = $listeners[$actionName];
		if(!$listener || !$listener['class']) return null;
		return BeanUtils::builtInstance($listener['class'], $listener['params']);
	}
	
	/**
	 * 获取键值操作器
	 * @return FileKeyValue
	 */
	public static function getFileKeyValue(){
		if(!R::$objects['fileKeyValue']){
			$storeDirectory = self::getConfig()->getConfig('base_compile_path') . Constant::CACHE_FILE_DIRECTORY . DIRECTORY_SEPARATOR;
			R::$objects['fileKeyValue'] = new FileKeyValue($storeDirectory);
		}
		return R::$objects['fileKeyValue'];
	}
}