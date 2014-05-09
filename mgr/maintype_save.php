<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__maintype';
$gourl  = 'maintype.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加二级分类
if($action == 'add')
{
	$parentstr = $do->GetParentStr();


	$sql = "INSERT INTO `$tbname` (parentid, parentstr, classname, orderid, checkinfo) VALUES ('$parentid', '$parentstr', '$classname', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改二级分类
else if($action == 'update')
{
	$parentstr = $do->GetParentStr();


	//更新所有关联parentstr
	if($parentid != $repid)
	{

		$childtbname = array('#@__infolist','#@__infoimg','#@__soft');


		//更新本类parentstr
		foreach($childtbname as $k=>$v)
		{
			$dosql->ExecNoneQuery("UPDATE `$v` SET mainpid='".$parentid."', mainpstr='".$parentstr."' WHERE mainid=".$id);
		}


		//更新下级parentstr
		$do->UpParentStr($id, $childtbname, 'mainpstr', 'mainid');
	}


	$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', classname='$classname', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
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