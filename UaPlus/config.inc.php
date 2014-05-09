<?php
/*
 * 说明：前端引用文件
*/

require_once(dirname(__FILE__).'/common.inc.php');
require_once(SITE_INC.'/func.class.php');
require_once(SITE_INC.'/page.class.php');


if(!defined('IN_SITE')) exit("Request Error!");


//网站开关
if($cfg_webswitch == 'N')
{
	echo $cfg_switchshow.'<br /><br /><i>'.$cfg_webname.'</i>';
	exit();
}

// 初始化常用变量
if (!isset($cid)){
	if (isset($_GET['cid'])){
		$cid = $_GET['cid'];
	}else{
		$cid = 0;
	}
}
if (!isset($id)){
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = 0;
	}
}
if (!isset($lang)){
	if (isset($_GET['lang'])){
		$lang = $_GET['lang'];
	}else{
		$lang = 1; // 默认使用第 1 种语言
	}
}

// 关闭多语言功能
if ('N'==$cfg_maintype) $lang = -1;

// 网站上线后
/*
if (!empty($onLine) && isset($onLine)){
	$dn = $_SERVER['SERVER_NAME'];
	// 将来自 xxxx.xxx.demo.wqit.net 的请求转至 www.xxxx.xxx
	if (FALSE !== strpos($dn,'.demo.wqit.net')){
		$dn = str_replace('.demo.wqit.net','',$dn);
		$uri = 'http://www.'.$dn.$_SERVER['REQUEST_URI'];
		// 跳转
		header("HTTP/1.1 301 Moved Permanently"); 
		header("location:$uri");
	}
	// 为 纯域名 网址添加“www.”
	if (FALSE === strpos($dn,'www.')){
		$uri = 'http://www.'.$dn.$_SERVER['REQUEST_URI'];
		// 跳转
		header("HTTP/1.1 301 Moved Permanently"); 
		header("location:$uri");
	}
}
*/
?>
