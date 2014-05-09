<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

$tbname = '#@__postarea';
$gourl  = 'postarea.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加配送区域
if($action == 'add')
{
	$parentstr = $do->GetParentStr();

	$sql = "INSERT INTO `$tbname` (parentid, parentstr, classname, freight, orderid, checkinfo) VALUES ('$parentid', '$parentstr', '$classname', '$freight', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//修改配送区域
if($action == 'update')
{
	$parentstr = $do->GetParentStr();

	$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', classname='$classname', freight='$freight', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
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