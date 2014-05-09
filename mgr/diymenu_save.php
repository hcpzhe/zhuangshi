<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__diymenu';
$gourl  = 'diymenu.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加自定义菜单项
if($action == 'add')
{
	$sql = "INSERT INTO `$tbname` (classname, parentid, linkurl, orderid, checkinfo) VALUES ('$classname', '0', '', '$orderid', '$checkinfo')";
	$dosql->ExecNoneQuery($sql);

	$r = $dosql->GetOne("SELECT id FROM `$tbname` WHERE classname='$classname' ORDER BY id DESC LIMIT 0,1");
	$parentid = $r['id'];

	$namenum = count($classnameadd);
	for($i=0; $i<$namenum; $i++)
	{
		if($classnameadd[$i] != '')
		{
			$dosql->ExecNoneQuery("INSERT INTO `$tbname` (classname, parentid, linkurl, orderid, checkinfo) VALUES ('$classnameadd[$i]', '$parentid', '$linkurladd[$i]', '$orderidadd[$i]', 'true')");
		}
	}
	
	header("location:$gourl");
	exit();
}


//修改自定义菜单项
else if($action == 'update')
{
	$sql = "UPDATE `$tbname` SET classname='$classname', parentid='0', linkurl='$linkurl', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
	$dosql->ExecNoneQuery($sql);

	$upidnum = count($upid);
	for($i=0; $i<$upidnum; $i++)
	{
		$dosql->ExecNoneQuery("UPDATE `$tbname` SET classname='$classnameupdate[$i]', parentid='$id', linkurl='$linkurlupdate[$i]', orderid='$orderidupdate[$i]', checkinfo='true' WHERE id=$upid[$i]");
	}

	$namenum = count($classnameadd);
	for($i=0; $i<$namenum; $i++)
	{
		if($classnameadd[$i] != '')
		{
			$dosql->ExecNoneQuery("INSERT INTO `$tbname` (classname, parentid, linkurl, orderid, checkinfo) VALUES ('$classnameadd[$i]', '$id', '$linkurladd[$i]', '$orderidadd[$i]', 'true')");
		}
	}

	header("location:$gourl");
	exit();
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>