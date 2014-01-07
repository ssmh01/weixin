<?php
/**
 *	This is a configre file for mvc framework.
 *	To make this configure work, use must set up a constant
 *  been named 'WEB_ROOT'.
 */
//Set up the base configure item;
$baseConfig = array();
//Web应用程序的根目录
$baseConfig['base_webroot'] = rtrim(WEB_ROOT, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
//框架的根目录
$baseConfig['base_easyphp_root'] = $baseConfig['base_webroot'] . 'easyphp/';
//模块的根目录
$baseConfig['base_modules_root'] = $baseConfig['base_webroot'] . 'modules/';
//模型配置的目录
$baseConfig['base_model_config_root'] = $baseConfig['base_modules_root'] . 'modelconfigs/';
//需要进行API包机制管理的目录,进行包机制管理的API类将会被自动引入,如果有同名类将会出现不可预料的错误。
//EasyPHP框架目录和模块的目录是默认被管理的，不需要重复添加，并且模块的类名不要和EasyPHP框架相同。
$baseConfig['base_packets'] = array();
//框架编译时用来保存编译结果的目录,绝对路径
$baseConfig['base_compile_path'] = $baseConfig['base_webroot'] . 'runtime/';
//分发控制器
$baseConfig['base_controller'] = 'Controller';	//see controller/Controller.php
//Action调用者
$baseConfig['base_action_invoker'] = 'ActionInvoker'; //see action/ActionInvoker.php
//匹配器,将按先后顺序调用
$baseConfig['base_matchers'] = array(
	array('class'=>'ContextMatcher'),
);
//URL是否静态化配置
$baseConfig['base_url_static'] = true;

//配置首页Action，必需
$baseConfig['base_index_action'] = array('module'=>'common', 'action'=>'index', 'method'=>'index');
//配置提示消息Action，如果不设置则不能使用show_message函数
$baseConfig['base_message_action'] = array('module'=>'common', 'action'=>'tip', 'method'=>'show');
//404页面(绝对路径)
$baseConfig['base_404_page'] = '/404.html';

//Set up the event configure item.
$eventConfig = array();
//WEB生命周期监听器
$eventConfig['event_web_lifetime_listener'] = 'WebLifeListener';
//分发监听器
$eventConfig['event_dispatch_listener'] = '';
//模型验证时监听器
$eventConfig['event_model_validate_listener'] = '';
//Action的监听器
$eventConfig['event_action_listeners'] = array();

//Set up the log configure item.
$logConfig = array();
$logConfig["log_level"] = 4; 	//	the log level:LogLevel::DEBUG
$logConfig["log_root"] = "runtime/log/";	//the default root path of log file

//Set up the template configure item.
$viewConfig = array();
$viewConfig["view_root"] = './templates/'; //must end with '/'
$viewConfig["view_style"] = 'default';
$viewConfig["view_suffix"] = '.htm';
$viewConfig["view_starttag"] = '{';
$viewConfig["view_endtag"] = '}';

//Set up the debug configure item.
$debugConfig = array();
$debugConfig['debug_enable'] = false;
$debugConfig['debug_display'] = 0;
//$debugConfig['debug_display'] = E_ALL & ~E_NOTICE & ~E_WARNING;
//$debugConfig['debug_display'] = E_ALL;

//Set up the cookie configure item.
$cookieConfig = array();
$cookieConfig['cookie_prefix'] = '';
$cookieConfig['cookie_lifetime'] = 3600*24;
$cookieConfig['cookie_domain'] = '';
$cookieConfig['cookie_path'] = '';
$cookieConfig['cookie_encode'] = '';
$cookieConfig['cookie_decode'] = '';

//Set up the session configure item.
$sessionConfig = array();
$sessionConfig['session_expire'] = 0;
$sessionConfig['session_cookie_lifetime'] = 0;
$sessionConfig['session_save_path'] = '';
$sessionConfig['session_domain'] = '';
$sessionConfig['session_path'] = '';
$sessionConfig['session_callback'] = '';

//设置全局语言.
$i18nConfig = array();
$i18nConfig['i18n_root'] = 'langs/';	//相对于网站根目录
$i18nConfig['i18n_base_name'] = 'lang';
$i18nConfig['i18n_locale'] = 'zh-CN';

//Set up the cache configure item.
$cacheConfig = array();
$cacheConfig['cache_driver'] = 'ApcCacheDriver';
$cacheConfig['cache_life_time'] = '0';	//永不过期
$cacheConfig['cache_expired_delete'] = true;
$cacheConfig['cache_data_source_class'] = 'CacheDataSource';	//缓存数据源类
$cacheConfig['cache_config_file'] = 'cache.config.php';	//缓存配置文件
$cacheConfig['cache_pre'] = 'yyx_';//缓存前缀

//Set up the database configure item.
$databaseConfig = array();
$databaseConfig['database_class'] = 'MySQL';
$databaseConfig['database_host'] = '';
$databaseConfig['database_name'] = '';
$databaseConfig['database_user'] = '';
$databaseConfig['database_password'] = '';
$databaseConfig['database_charset'] = 'utf8';
$databaseConfig['database_prefix'] = 'yyx_';//数据库表前缀

//网站自己的配置
$siteConfig = array(
	'site_url'=>'',
	'site_name'=>'预言星',
);

//附件配置
$attachConfig['attach_filepath'] = WEB_ROOT.'res/attach/';
$attachConfig['attach_webpath'] = '/res/attach/';

//上传配置
$uploadConfig['upload_dir'] = 'res/attached/';//文件保存的目录
$uploadConfig['upload_save_path'] = realpath($baseConfig['base_webroot'].$uploadConfig['upload_dir']);//文件保存的路径
$uploadConfig['upload_save_url'] = $siteConfig['site_url'].'/'.$uploadConfig['upload_dir'];//文件访问的路径
//允许上传的类型
$uploadConfig['upload_allow_ext'] = array(
    'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
    'flash' => array('swf', 'flv'),
    'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
    'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);


$adminConfig['admin_super_id'] = 1;//初始的管理员id，此账号不能删除

return array_merge($baseConfig, $eventConfig, $logConfig, $viewConfig, $debugConfig, $cookieConfig, $sessionConfig, $i18nConfig, $cacheConfig, $databaseConfig, $siteConfig, $uploadConfig, $attachConfig, $adminConfig);
