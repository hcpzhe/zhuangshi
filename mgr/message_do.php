<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//回复留言
if($action == 'remsg')
{
	$retime = GetDateTime(time());
	$sql = "UPDATE `#@__message` SET recont='$msg', retime='$retime' WHERE id=$id";
	$dosql->ExecNoneQuery($sql);

	$r = $dosql->GetOne("SELECT htop,rtop,recont FROM `#@__message` WHERE id=$id");
	$content = '';
	if($r['htop'] == 'true') $content .= '置顶 ';
	if($r['rtop'] == 'true') $content .= '推荐 ';
	if($r['recont'] != '') $content .= '[已回复]';
	echo $content;
	exit();
}
?>