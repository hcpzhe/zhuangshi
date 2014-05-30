<?php
require_once(dirname(__FILE__).'/config.php'); 
//留言ajax存库
if(isset($action) and $action=='add')
{
	if(empty($nickname))
	{
		RSerror('姓名不能为空！The name can not be empty!');
	}
	
	if(empty($contact))
	{
		RSerror('联系电话不能为空！Contact can not be empty!');
	}
	
	$success_msg = empty($tomsg) ? '提交成功！' : $tomsg;

	$r = $dosql->GetOne("SELECT Max(orderid) AS orderid FROM `#@__message`");
	$orderid  = (empty($r['orderid']) ? 1 : ($r['orderid'] + 1));
	$nickname = htmlspecialchars($nickname);
	$contact  = htmlspecialchars($contact);
	@$msgtype  = htmlspecialchars($msgtype);
	@$yusuan  = htmlspecialchars($yusuan);
	@$content  = htmlspecialchars($content);
	$posttime = GetMkTime(time());
	$ip       = gethostbyname($_SERVER['REMOTE_ADDR']);
	

	$sql = "INSERT INTO `#@__message` (nickname, contact, msgtype, yusuan, content, orderid, posttime, htop, rtop, checkinfo, ip) VALUES ('$nickname', '$contact', '$msgtype', '$yusuan', '$content', '$orderid', '$posttime', '', '', 'false', '$ip')";
	if($dosql->ExecNoneQuery($sql))
	{
		RSsuccess($success_msg);
	}else {
		RSerror('提交失败, 请联系管理员');
	}
}

function RSerror($message='',$jumpUrl='') {
	ajaxMsg($message,0,$jumpUrl);
}
function RSsuccess($message='',$jumpUrl='') {
	ajaxMsg($message,1,$jumpUrl);
}

function ajaxMsg($message,$status,$jumpUrl='') {
	$data = array();
	$data['info']   =   $message;
	$data['status'] =   $status;
	$data['url']    =   $jumpUrl;
	header('Content-Type:application/json; charset=utf-8');
	exit(json_encode($data));
}
