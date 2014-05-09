<?php
header('Content-Type: text/html; charset=utf-8');

if(phpversion() < '5.2.0')
{
	exit('用户您好，由于您的php版本过低，不能安装本软件，为了系统功能全面可用，请升级到5.2.0或更高版本再安装，谢谢！<br />');
}


@set_time_limit(0); //设定超时时间
define('INSTALL_PATH', preg_replace("/[\/\\\\]{1,}/", '/', dirname(__FILE__))); //设置系统路径
define('IN_INSTALL', TRUE); //发放登入牌


//提示已经安装
if(is_file(INSTALL_PATH.'/../data/install_lock.txt') and @$_GET['s'] != md5('done'))
{
	require_once(INSTALL_PATH.'/templets/step_5.html');
	exit();
}

$s = !empty($_POST['s']) ? intval($_POST['s']) : 1;

//如果有GET值则覆盖POST值
if(!empty($_GET['s']))
{
	if($_GET['s']==1 or $_GET['s']==15271 or $_GET['s']==md5('done'))
	{
		$s = $_GET['s'];
	}
}

switch($s)
{
	case 0: //协议说明
	require_once(INSTALL_PATH.'/templets/step_0.html'); 
	break;
	
	case 1: //环境检测
	//$iswrite_array = array('/data/','/data/backup/','/data/update/','/include/conn.inc.php','/include/config.cache.php','/uploads/');
	$iswrite_array = array('/data/','/data/backup/','/data/update/','/data/conn.inc.php','/data/config.cache.php','/uploads/');
	$exists_array = array('is_writable','function_exists','mysql_connect');
	require_once(INSTALL_PATH.'/templets/step_1.html');
	break;

	case 2: //配置文件
	require_once(INSTALL_PATH.'/templets/step_2.html');
	break;
	
	case 3: //正在安装
	require_once(INSTALL_PATH.'/templets/step_3.html');
	break;

	case 15271: //检测数据库信息
	if(@mysql_connect($_GET['dbhost'], $_GET['dbuser'], $_GET['dbpw'])) echo 'true';
	else echo 'false';
	break;

	case md5('done'): //安装完成
	require_once(INSTALL_PATH.'/templets/step_4.html');
	$fp = fopen(INSTALL_PATH.'/../data/install_lock.txt', 'w');
	fwrite($fp, '程序已正确安装，重新安装请删除本文件');
	fclose($fp);
	break;

	default: //协议说明
	require_once(INSTALL_PATH.'/templets/step_0.html');
	break;
}


//测试可写性
function ck_iswrite($file)
{
	if(is_writable($file))
	{
		echo '<span class="install_true">可写</span>';
	}
	else
	{
		echo '<span class="install_false">不可写</span>';
		$GLOBALS['isnext'] = 'N';
	}
}

//测试函数是否存在
function funexists($func)
{
	if(function_exists($func))
	{
		echo '<span class="install_true">支持</span>';
	}
	else
	{
		echo '<span class="install_false">不支持</span>';
		$GLOBALS['isnext'] = 'N';
	}
}

//测试函数是否存在，返回建议
function funadvice($func)
{
	if(function_exists($func))
	{
		echo '<span style="color:#999;">无</span>';
	}
	else
	{
		echo '<span style="color:red">建议安装</span>';
		$GLOBALS['isnext'] = 'N';
	}
}
?>