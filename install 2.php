<?php
error_reporting(E_ERROR | E_PARSE);

@set_time_limit(0);
set_magic_quotes_runtime(0);
if(!@ini_get('register_globals') || !get_magic_quotes_gpc())
{
	@extract($_POST, EXTR_SKIP);
	@extract($_GET, EXTR_SKIP);
}
!$_POST && $_POST = array();
!$_GET && $_GET = array();
define('YYX_ROOT', dirname(__FILE__) . '/');
$basename = "install.php";

if(empty($step)) //显示表单
{
	include YYX_ROOT . 'install.htm';
	exit();	
}
elseif($step == '2') //安装
{
	$installinfo = ''; //用于存放安装信息
	$site_url = 'http://' . $_SERVER['SERVER_NAME'];	

	$timestamp = time();
	$link = mysql_connect($database_host, $database_user, $database_password); //连接数据库
	!$link && exit("数据库连接失败，请检查配置信息是否填写正确 <br /><br /><a href=';' onclick='javascript:history.go(-1);'>返回重新填写</a>");
	if(!@mysql_select_db($database_name,$link))
	{
		mysql_query("CREATE DATABASE $database_name DEFAULT CHARACTER SET UTF8", $link); //创建数据库
		mysql_error($link) && exit('数据库不存在,且您无权限建立,请联系服务器管理员!');
	}
	
	mysql_select_db($database_name,$link);
	mysql_query("SET NAMES UTF8");
	
	create_table(YYX_ROOT . "install.sql"); //导入数据
	$timestamp = time();
	$admin_password = md5(md5($admin_password));
	mysql_query("INSERT INTO yyx_manager SET name='$admin_username', password='$admin_password', mobile='', group_id='1', allow_login='1', last_login_time='0', create_time='$timestamp'", $link);
	
	//修改配置文件
	$install_config_content = file_get_contents(YYX_ROOT . 'install_config.php');
	$config_content = str_replace(
		array(
			'$databaseConfig[\'database_host\'] = \'\';',
			'$databaseConfig[\'database_name\'] = \'\';',
			'$databaseConfig[\'database_user\'] = \'\';',
			'$databaseConfig[\'database_password\'] = \'\';',
			'\'site_url\'=>\'\','
		), 
		array(
		'$databaseConfig[\'database_host\'] = \''.$database_host.'\';',
		'$databaseConfig[\'database_name\'] = \''.$database_name.'\';',
		'$databaseConfig[\'database_user\'] = \''.$database_user.'\';',
		'$databaseConfig[\'database_password\'] = \''.$database_password.'\';',
		'\'site_url\'=>\''.$site_url.'\','			
		), 
		$install_config_content
	);
	file_put_contents(YYX_ROOT . 'config.php', $config_content);
	include (YYX_ROOT . 'install.htm');
	
	//删除安装文件
	if(@unlink(YYX_ROOT . 'install.php'))
	{
		@unlink(YYX_ROOT . 'install.htm');
		@unlink(YYX_ROOT . "install.sql");
		@unlink(YYX_ROOT . "install_config.php");
	}
	exit();	
}

function create_table($filename)
{
	global $link, $installinfo;

	$sql = file($filename);
	$query = '';
	foreach($sql as $key => $value)
	{
		$value = trim($value);
		if(!$value || $value[0] == '#' || substr($value, 0, 3) == '-- ' || $value == '--') continue;
		if(eregi("\;$", $value))
		{
			$query .= $value;
			if(eregi("^CREATE", $query))
			{
				$name = substr($query, 13, strpos($query, '(') - 13);
				$c_name = $name;
				$installinfo .= '<font color="#0000EE">建立数据表</font>' . $c_name . ' ... <font color="#0000EE">成功</font><br>';

				$extra = substr(strrchr($query, ')'), 1);
				$query = str_replace($extra, '', $query);
				$extra = "ENGINE=MyISAM DEFAULT CHARSET=UTF8;";
				$query .= $extra;
			}
			mysql_query($query, $link) or exit(mysql_error($link));
			$query = '';
		}
		else
		{
			$query .= $value;
		}
	}
}

?>