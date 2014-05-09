<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

if($action == 'checkuser')
{
	$dosql->Execute("SELECT username FROM `#@__member` WHERE username='$username'");
	if($dosql->GetTotalRow() < 1)
	{
		echo '<span class="reok">可以使用</span>';
	}
	else
	{
		echo '<span class="renok">用户名已存在</span>';
	}
}
?>