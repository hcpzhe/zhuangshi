<?php
$dn = basename(realpath(dirname(__FILE__).'/../'));
require_once(dirname(__FILE__).'/../../UaPlus/common.inc.php');

//启动SESSION
session_start();


//初始化参数
$action = isset($action) ? $action : '';


//
if($action == 'lock')
{
	$_SESSION['lockname'] = $_SESSION['admin'];
	unset($_SESSION['admin']);
	exit();
}


else if($action == 'check')
{
	$row = $dosql->GetOne("SELECT `password` FROM `#@__admin` WHERE username='".$_SESSION['lockname']."'");

	if($row['password'] == md5(md5($password)))
	{
		$_SESSION['admin'] = $_SESSION['lockname'];
		unset($_SESSION['lockname']);
		echo true;
		exit();
	}
	else
	{
		echo false;
		exit();
	}
}


//无条件返回
else
{
	exit();
}
?>