<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__message';
$gourl  = 'message.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加留言
if($action == 'add')
{
	if(!isset($htop)) $htop = '';
	if(!isset($rtop)) $rtop = '';
	$posttime = GetMkTime($posttime);

	$sql = "INSERT INTO `$tbname` (nickname, contact, content, orderid, posttime, htop, rtop, checkinfo, ip) VALUES ('$nickname', '$contact', '$content', '$orderid', '$posttime', '$htop', '$rtop', '$checkinfo', '$ip')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改留言
else if($action == 'update')
{
	if(!isset($htop)) $htop = '';
	if(!isset($rtop)) $rtop = '';
	$posttime = GetMkTime($posttime);

	$sql = "UPDATE `$tbname` SET nickname='$nickname', contact='$contact', content='$content', orderid='$orderid', posttime='$posttime', htop='$htop', rtop='$rtop', checkinfo='$checkinfo' WHERE id=$id";
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