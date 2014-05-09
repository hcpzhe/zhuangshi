<?php
require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__admanage';
$gourl  = 'admanage.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加广告信息
if($action == 'add')
{
	$r = $dosql->GetOne("SELECT parentid FROM `#@__adtype` WHERE id=$classid");
	$parentid  = $r['parentid'];
	$parentstr = $do->GetParentStr($parentid);

	$posttime = GetMkTime($posttime);

	$sql = "INSERT INTO `$tbname` (title, classid, parentid, parentstr, admode, picurl, adtext, linkurl, posttime, orderid, checkinfo) VALUES ('$title', '$classid', '$parentid', '$parentstr', '$admode', '$picurl', '$adtext', '$linkurl', '$posttime', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改广告信息
else if($action == 'update')
{
	$r = $dosql->GetOne("SELECT parentid FROM `#@__adtype` WHERE id=$classid");
	$parentid  = $r['parentid'];
	$parentstr = $do->GetParentStr($parentid);

	$posttime = GetMkTime($posttime);

	$sql = "UPDATE `$tbname` SET title='$title', classid='$classid', parentid='$parentid', parentstr='$parentstr', admode='$admode', picurl='$picurl', adtext='$adtext', linkurl='$linkurl', posttime='$posttime', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>