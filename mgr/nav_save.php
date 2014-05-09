<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__nav';
$gourl  = 'nav.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加导航菜单
if($action == 'add')
{
	$parentstr = $do->GetParentStr();


	$sql = "INSERT INTO `$tbname` (parentid, parentstr, classname, linkurl, relinkurl, picurl, orderid, checkinfo) VALUES ('$parentid', '$parentstr', '$classname', '$linkurl', '$relinkurl', '$picurl', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改导航菜单
else if($action == 'update')
{
	$parentstr = $do->GetParentStr();


	//更新所有关联parentstr
	if($parentid != $repid)
	{
		//更新下级parentstr
		$do->UpParentStr($id, $childtbname, 'parentstr', 'classid');
	}


	$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', classname='$classname', linkurl='$linkurl', relinkurl='$relinkurl', picurl='$picurl', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";


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