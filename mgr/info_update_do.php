<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

$row = $dosql->GetOne("SELECT * FROM `#@__info` WHERE classid=$classid AND mainid=$mainid");
if(is_array($row))
{
	echo $row['content'].'[-||-]'.$row['picurl'].'[-||-]'.GetDateTime($row['posttime']);
	exit();
}
else
{
	echo '[-||-][-||-]'.GetDateTime(time());
	exit();
}
?>