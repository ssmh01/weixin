<?php
header("Content-type: text/html; charset=utf-8");
define('WEB_ROOT', rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);
//定义扩展库路径
define('EXT_LIB_ROOT', WEB_ROOT . 'lib/');
include_once WEB_ROOT . 'easyphp/EasyPHP.class.php';
//配置文件.
$configFile = WEB_ROOT . 'config.php';

//个人主页
$URIstr = $_SERVER['REQUEST_URI'];
$URIstr = trim($URIstr, '/');
if(strpos($URIstr, '/') === false && strpos($URIstr, '?') === false && !empty($URIstr))
{
	header("Location: /member/space/website-".$URIstr.'.shtml');
}

EasyPHP::doItEasy($configFile);