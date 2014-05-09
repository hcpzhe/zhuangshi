<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化变量
$bigurl   = 'templets/html/default.html';
$smallurl = 'templets/html/default_user.html';


/*
 * 浏览状态，$_SESSION['adminlevel']
 *
 * 0 超级管理员 1 普通管理员 2 文章管理员 
 * 10 包含所有身份(切换身份的虚拟值)
*/

if($_SESSION['adminlevel'] == 0 or $_SESSION['adminlevel'] == 10)
{
	if(empty($gourl))
	{
		require_once($bigurl);
		$_SESSION['adminlevel'] = 0;
	}
	else
	{
		require_once($smallurl);
		$_SESSION['adminlevel'] = 10;
	}
}

else
{
	require_once($smallurl);
}
?>