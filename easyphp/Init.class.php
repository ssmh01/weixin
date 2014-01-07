<?php

/**
 * This class use to initialize framework resources(objects or others).
 *
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-24
 */
abstract class Init{

	/**
	 * initialize EasyConfig
	 * @param array $params
	 */
	public static function configInit($configFile){
		$config = new EasyConfig(null);
		$config->addConfigs(include($configFile));
		R::setConfig($config);
		return $config;
	}
	
	/**
	 * 初始化包机制
	 */
	public static function packetInit(){
		$easyConfig = R::getConfig();
		include_once($easyConfig->getConfig('base_easyphp_root') . 'EasyPacket.class.php');
		$easyPacket = new EasyPacket($easyConfig->getConfig('base_easyphp_root'));
		$easyPacket->contain($easyConfig->getConfig('base_modules_root'));
		$compilePath = $easyConfig->getConfig('base_compile_path');
		if(!$compilePath){
			$compilePath = $easyConfig->getConfig('base_easyphp_root') . 'compiled/';
		}
		$packetDescFileName = $easyConfig->getConfig('base_packet_desc_name');
		if(empty($packetDescFileName)){
			$packetDescFileName = 'packet.php';
		}
		$packets = R::getConfig()->getConfig('base_packets');
		foreach($packets as $packet){
			$easyPacket->contain($packet);
		}
		$easyPacket->setCompilePath($compilePath);
		$easyPacket->setPacketDescFileName($packetDescFileName);
		$force = $easyConfig->getConfig('debug_enable');
		$easyPacket->complie($force)->asAutoLoad();
		R::setPacket($easyPacket);
	}
	
	/**
	 * initialize HttpRequest
	 * @param array $params
	 */
	public static function requestInit(){
		$context = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$contextPattern = "/^[\w\d\/]+$/";
		if(!preg_match($contextPattern, $context)){
			$context_separator = '/';
			$context = String::cutFromLast($context, $context_separator) . $context_separator;
		}
		$requestURI = $_SERVER['REQUEST_URI'];
		$method = $_SERVER['REQUEST_METHOD'];
		$referer = $_SERVER['HTTP_REFERER'];
		$protocol = $_SERVER['SERVER_PROTOCOL'];
		$parameters = $_GET+$_POST;
		$files = $_FILES;
			
		$params = array();
		$params['context'] = $context;
		$params['requestURI'] = $requestURI;
		$params['method'] = $method;
		$params['referer'] = $referer;
		$params['protocol'] = $protocol;
		$params['parameters'] = $parameters;
		$params['files'] = $files;
		return BeanUtils::builtInstance('HttpRequest', $params);
	}
	
	public static function actionInit(ActionMapping $mapping){
		//创建模块
		$moduleName = $mapping->getModule();
		$module = new Module($moduleName);
		//配置模块
		$moduleConfigFile = get_module_dir($moduleName) . Constant::MODULE_CONFIG_FILE_NAME;
		$moduleConfig = include($moduleConfigFile);
		$moduleConfig = new EasyConfig($moduleConfig);
		$module->setConfig($moduleConfig);
		R::setCurrentModule($module);
		
		$action = $mapping->getAction();
		if(empty($action) || !is_string($action)) return null;
		$action = ucfirst($action) . 'Action';
		//手动加载模块下面的类
        $actionPath = $mapping->getModule() . '.'. Constant::ACTION_DIRECTION_NAME . '.' . $action;
        if(!import($actionPath)){
        	$actionNotFoundException = new ActionNotFoundException("没找到指定的Action:".$actionPath);
        	$actionNotFoundException->setRequestURI(R::getRequest()->getRequestURI());
        	throw $actionNotFoundException;
        }
		try{
			return BeanUtils::builtInstance($action, array('actionMapping'=>$mapping, 'module'=>$module));
		}catch(ReflectionException $ex){
			$actionNotFoundException = new ActionNotFoundException($ex->getMessage());
			$actionNotFoundException->setRequestURI(R::getRequest()->getRequestURI());
			throw $actionNotFoundException;
		}
	}
	
	/**
	 * initialize HttpCookie
	 */
	public static function cookieInit(){
		if(HttpCookie::init()){
			return;
		}
		$easyConfig = R::getConfig();
		$prefix = $easyConfig->getConfig('cookie_prefix');
		$lifetime = $easyConfig->getConfig('cookie_lifetime');
		$domain = $easyConfig->getConfig('cookie_domain');
		$path = $easyConfig->getConfig('cookie_path');
		$decode = $easyConfig->getConfig('cookie_decode');
		$encode = $easyConfig->getConfig('cookie_encode');
		HttpCookie::prefix($prefix);
		if($lifetime){
			HttpCookie::lifetime($lifetime);
		}
		HttpCookie::domain($domain);
		HttpCookie::path($path);
		HttpCookie::decode($decode);
		HttpCookie::encode($encode);
		HttpCookie::init(true);
	}

	/**
	 * initialize HttpSession
	 */
	public static function sessionInit(){
		if(HttpSession::init()){
			return;
		}
		$easyConfig = R::getConfig();
		ini_set('session.auto_start', 0);
		$lifetime = $easyConfig->getConfig('session_cookie_lifetime');
		$savePath = $easyConfig->getConfig('session_save_path');
		$domain = $easyConfig->getConfig('session_domain');
		$path = $easyConfig->getConfig('session_path');
		$callback = $easyConfig->getConfig('session_callback');
		$expire = $easyConfig->getConfig('session_expire');
		if($lifetime){
			HttpSession::cookieLifetime($lifetime);
		}
		if($savePath){
			HttpSession::savePath($savePath);
		}
		if($domain){
			HttpSession::domain($domain);
		}
		if($path){
			HttpSession::path($path);
		}
		if($callback){
			HttpSession::unserializeCallback($callback);
		}
		HttpSession::start();
		if($expire){
			HttpSession::setExpire($expire, true);
		}
		HttpSession::init(true);
	}

	/**
	 * initialize Loacle.
	 */
	public static function localeInit(){
		$locale = R::getRequest()->getParameter(Constant::I18N_LOCALE_VAR);
		$locale = empty($locale)? HttpSession::get(Constant::I18N_LOCALE_VAR) : $locale;
		$locale = empty($locale)? R::getConfig()->getConfig('i18n_locale') : $locale;
		$locale = empty($locale)? get_client_language() : $locale;
		return empty($locale)? Locale::getDefault() : Locale::create($locale);
	}

	/**
	 * initialize Language.
	 */
	public static function languageInit(){
		$request = R::getRequest();
		$baseName = $request->getParameter(Constant::I18N_BASE_NAME_VAR);
		$baseName = empty($baseName)? HttpSession::get(Constant::I18N_BASE_NAME_VAR) : $baseName;
		$baseName = empty($baseName)? R::getConfig()->getConfig('i18n_base_name') : $baseName;
		$easyConfig = R::getConfig();
		//全局语言文件根目录
		$fullLanageRoot = $easyConfig->getConfig('i18n_root');
		$fullLanageRoot && $fullLanageRoot = $easyConfig->getConfig('base_webroot') . $fullLanageRoot;
		//模块语言文件根目录
		$currentModule = R::getCurrentModule();
		if($currentModule){
			$moduleConfig = $currentModule->getConfig();
			$moduleLanguageRoot = $moduleConfig->getConfig('i18n_root');
			$moduleLanguageRoot && $moduleLanguageRoot = get_module_dir( R::getCurrentModule()->getName()) . $moduleLanguageRoot;
		}
		//组合全局语言和模块语言
		$lanageRoots = array($fullLanageRoot, $moduleLanguageRoot);
		$locale = self::localeInit();
		$language = new Language($lanageRoots, $baseName);
		$language->loadLanguages($locale);
		return $language;
	}
	
	/**
	 * initialize Log
	 */
	public static function logInit(){
		$log = new Log();
		$log->setLevel(R::getConfig()->getConfig('log_level'));
		$logRoot = get_config('base_webroot') . get_config('log_root');
		if(R::getConfig()->getConfig('debug_enable')){
			Permission::checkWritePerm($logRoot);
		}
		$logFile = $logRoot . date('Y-m-d', time()) . '.log';
		
		if(file_exists($logFile) && R::getConfig()->getConfig('debug_enable')){
			Permission::checkWritePerm($logFile);
		}
		$log->setLogFile($logFile);
		LogHelper::setLog($log);
		return $log;
	}
	
	/**
	 * initialize cache
	 */
	public static function cacheInit(){
		$easyConfig = R::getConfig();
		$cacheConfig = new CacheConfig();
		$cacheConfig->setCacheDriver($easyConfig->getConfig('cache_driver'));
		$cacheConfig->setLifetime($easyConfig->getConfig('cache_life_time'));
		$cacheConfig->setCacheDataSourceClass($easyConfig->getConfig('cache_data_source_class'));
		$cacheConfig->setDeleteExpiredCache($easyConfig->getConfig('cache_expired_delete'));
		$cacheFile = $easyConfig->getConfig('cache_config_file');
		if($cacheFile){
			$cacheFile = $easyConfig->getConfig('base_webroot') . $cacheFile;
			if(file_exists($cacheFile)){
				$configs = include($cacheFile);
				$cacheConfig->setConfigs($configs['base']);
				$cacheConfig->setCacheMap($configs['caches']);
			}
		}
		$cache = new Cache($cacheConfig);
		return $cache;
	}
	
	public static function dbInit(){
		$easyConfig = R::getConfig();
		$db_class = $easyConfig->getConfig('database_class');
		$host = $easyConfig->getConfig('database_host');
		$database = $easyConfig->getConfig('database_name');
		$user = $easyConfig->getConfig('database_user');
		$password = $easyConfig->getConfig('database_password');
		$charset = $easyConfig->getConfig('database_charset');
		//创建数据库类
		$db = BeanUtils::builtInstance($db_class);
		$connectParameter = new ConnectParameter();
		$connectParameter->setHost($host);
		$connectParameter->setDatabase($database);
		$connectParameter->setUser($user);
		$connectParameter->setPassword($password);
		$connectParameter->setCharset($charset);
		$db->connect($connectParameter);
		return $db;
	}
	
	public static function daoInit($dao){
		$easyConfig = R::getConfig();
		$databaseAccesser = R::getDatabaseAccesser(); //@debug getDatabaseAccesser不存在
		$daoName = $easyConfig->getFullDaoRoot() . ucwords($dao) . 'Dao.php';
		$daoObject = BeanUtils::builtInstance($daoName);
		$daoObject->setDatabaseAccesser($databaseAccesser);
		return $daoObject;
	}
	
	
	public static function listennerInit($listenner){
		$easyConfig = R::getConfig();
		include_once($easyConfig->getFullListennerRoot() . $listenner . '.php');
		return BeanUtils::builtInstance($listenner);
	}
	
	private static function contextInit(){
		$uri = $_SERVER['REQUEST_URI'];
		$context = '/';
		if(empty($uri)){
			return $context;
		}
		return $uri;
	}
}