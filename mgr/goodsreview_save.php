<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__goodsreview';
$gourl  = 'goodsreview.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加商品评论
if($action == 'add')
{
	$posttime = GetMkTime($posttime);

	$sql = "INSERT INTO `$tbname` (goodsid, nickname, content, orderid, posttime, checkinfo, ip) VALUES ('$goodsid', '$nickname', '$content', '$orderid', '$posttime', '$checkinfo', '$ip')";
	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//修改商品评论
else if($action == 'update')
{
	$posttime = GetMkTime($posttime);

	$sql = "UPDATE `$tbname` SET goodsid='$goodsid', nickname='$nickname', content='$content', orderid='$orderid', posttime='$posttime', checkinfo='$checkinfo' WHERE id=$id";
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