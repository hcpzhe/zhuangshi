<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__infoclass';


//跳转地址
if($cutover_url == 'small')
{
	if(!isset($tid))
	{
		if(isset($id)) $tid = $id;
		else $tid = $parentid;
		$r = $dosql->GetOne("SELECT parentstr FROM `$tbname` WHERE id=$tid");
		$r2 = explode(',',$r['parentstr']);
		if($r2[1] != '') $tid = $r2[1];
	}
	$gourl = 'infoclass_user.php?tid='.$tid;
}
else
{
	$gourl = 'infoclass.php';
}


/*
**删除栏目前连带数据
**必须在引入操作类前执行
*/
if($action == 'del')
{
	//删除栏目的单页信息
	$dosql->ExecNoneQuery("DELETE FROM `#@__info` WHERE classid=$id");
}


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加栏目
if($action == 'add')
{
	$parentstr = $do->GetParentStr();
	if(!isset($adminmenu)) $adminmenu = '';
	if(!isset($menulevel)) $menulevel = 0;

	$sql = "INSERT INTO `$tbname` (parentid, parentstr, infotype, classname, linkurl, picurl, seotitle, keywords, description, orderid, checkinfo, adminmenu, menulevel) VALUES ('$parentid', '$parentstr', '$infotype', '$classname', '$linkurl', '$picurl', '$seotitle', '$keywords', '$description', '$orderid', '$checkinfo', '$adminmenu', '$menulevel')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改栏目
else if($action == 'update')
{
	$parentstr = $do->GetParentStr();
	if(!isset($adminmenu)) $adminmenu = '';
	if(!isset($menulevel)) $menulevel = 0;


	//更新所有关联parentstr
	if($parentid != $repid)
	{

		$childtbname = array('#@__infolist','#@__infoimg','#@__soft');


		//更新本类parentstr
		foreach($childtbname as $k=>$v)
		{
			$dosql->ExecNoneQuery("UPDATE `$v` SET parentid='".$parentid."', parentstr='".$parentstr."' WHERE classid=".$id);
		}


		//更新下级parentstr
		$do->UpParentStr($id, $childtbname, 'parentstr', 'classid');
	}


	//来自小后台的提交不允许更改
	//是否为管理菜单与菜单管理级别
	if($cutover_url != 'small')
	{
		$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', infotype='$infotype', classname='$classname', linkurl='$linkurl', picurl='$picurl', seotitle='$seotitle', keywords='$keywords', description='$description', orderid='$orderid', checkinfo='$checkinfo', adminmenu='$adminmenu', menulevel='$menulevel' WHERE id=$id";
	}
	else
	{
		$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', infotype='$infotype', classname='$classname', linkurl='$linkurl', picurl='$picurl', seotitle='$seotitle', keywords='$keywords', description='$description', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
	}

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