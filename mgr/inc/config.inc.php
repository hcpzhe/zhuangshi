<?php
define('ADMIN_INC', preg_replace("/[\/\\\\]{1,}/", '/', dirname(__FILE__)));
define('ADMIN_ROOT', preg_replace("/[\/\\\\]{1,}/", '/', substr(ADMIN_INC, 0, -3)));
define('ADMIN_TEMP', ADMIN_ROOT.'templets');
$dn = basename(dirname(dirname(ADMIN_INC)));
//echo $dn . '<br>';
//echo ADMIN_INC . '<br>';
//echo ADMIN_ROOT . '<br>';
//echo ADMIN_TEMP . '<br>';
require_once(ADMIN_ROOT.'../UaPlus/common.inc.php');
require_once(ADMIN_INC.'/admin.func.php');
require_once(ADMIN_INC.'/page.class.php');


//是否允许在后台编辑PHP
$cfg_editfile = 'N';


//开启Session
session_start();


//检测是否登录
if(!isset($_SESSION['admin']) || !isset($_SESSION['adminlevel']) || !isset($_SESSION['logintime']))
{
	$_SESSION = array();
	session_destroy();
	echo '<script type="text/javascript">window.top.location.href="login.php";</script>';
	exit();
}


//不允许直接通过路径访问
if(!isset($_SERVER["HTTP_REFERER"]) && substr(GetCurUrl(), -11) != 'default.php')
{
	header('location:nofromurl.php');
	exit();
}


//设置来路变量 控制大小后台切换
if($_SESSION['adminlevel'] != 0)
{
	$cutover_url = 'small';
}
else
{
	$cutover_url = '';
}
?>