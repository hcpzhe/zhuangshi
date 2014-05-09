<?php	require(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__adtype';
$gourl  = 'adtype.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加广告位
if($action == 'add')
{
	$parentstr = $do->GetParentStr();

	$sql = "INSERT INTO `$tbname` (parentid, parentstr, classname, width, height, orderid, checkinfo) VALUES ('$parentid', '$parentstr', '$classname', '$width', '$height', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改广告位
else if($action == 'update')
{
	$parentstr = $do->GetParentStr();

	$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', classname='$classname', width='$width', height='$height', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
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