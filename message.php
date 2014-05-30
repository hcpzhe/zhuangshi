<?php error_reporting(0);?>
<?php require_once(dirname(__FILE__).'/config.php'); 
//留言内容处理
if(isset($action) and $action=='add')
{
	if(empty($nickname))
	{
		ShowMsg('昵称不能为空！The nickname can not be empty!','message.php');
		exit();
	}
	
	if(empty($content))
	{
		ShowMsg('内容不能为空！Content can not be empty!','message.php');
		exit();
	}


	$r = $dosql->GetOne("SELECT Max(orderid) AS orderid FROM `#@__message`");
	$orderid  = (empty($r['orderid']) ? 1 : ($r['orderid'] + 1));
	$nickname = htmlspecialchars($nickname);
	$contact  = htmlspecialchars($contact);
	$content  = htmlspecialchars($content);
	$posttime = GetMkTime(time());
	$ip       = gethostbyname($_SERVER['REMOTE_ADDR']);
	

	$sql = "INSERT INTO `#@__message` (nickname, contact, content, orderid, posttime, htop, rtop, checkinfo, ip) VALUES ('$nickname', '$contact', '$content', '$orderid', '$posttime', '', '', 'false', '$ip')";
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('预约成功，感谢您的支持！<br />Published successfully!','message.php');
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?> - 在线预约</title>
<meta name="author" content="<?php echo $cfg_author; ?>" />
<meta name="keywords" content="<?php echo $cfg_keyword; ?>" />
<meta name="description" content="<?php echo $cfg_description; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery1.min.js"></script>
<script type="text/javascript">
function cfm_msg()
{
	if($("#nickname").val() == "")
	{
		alert("请填写昵称！Please fill nickname!");
		$("#nickname").focus();
		return false;
	}
	if($("#content").val() == "")
	{
		alert("请填写留言内容！Please enter message content!");
		$("#content").focus();
		return false;
	}
	$("#form").submit();
}
</script>
</head>
<body>
<?php include('head.php');?>
<div class="ad"> <a href="/book" class="pr fl service_tel"></a>
  <div class="pr fr service_cont"> <a class="pr fl service_bnt s_bnt1" rel="nofollow" href="#"></a> <a class="pr fl service_bnt s_bnt2" rel="nofollow" href="#"></a> <a class="pr fl service_bnt s_bnt3" rel="nofollow" href="#"></a> <a class="pr fl service_bnt s_bnt4" rel="nofollow" href="#"></a>
    <div class="pr fl service_links"> <a class="pa service_wb" style="height:120px;" rel="nofollow" target="_blank" href="#"></a> <a class="pa service_email" style="height:120px;" rel="nofollow" href="#"></a> </div>
  </div>
</div>
<div class="Column Leader"> <em>当前位置</em> <a href="index.php">首页</a> - <a>在线预约</a> </div>
<div class="Column" style="width:960px;">
  <div class="Column-R">
    <div class="main_r_nav">
      <p>在线预约</p>
    </div>
    <div class="main_r_con">
      <dd>
                    <h3>在线预约</h3>
<div class="message_warp">
				<div class="message_bg">
					<div class="message_wz"><?php echo t('我们热忱接受您的意见和建议',$lang);?></div>
					<form name="form" id="form" method="post" action="">
						<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="80" height="34" align="right" class="message_labes">姓名：&nbsp;</td>
								<td><input name="nickname" type="text" id="nickname" class="message_input" /></td>
							</tr>
							<tr>
								<td height="34" align="right" class="message_labes">电话：&nbsp;</td>
								<td><input name="contact" type="text" id="contact" class="message_input" /></td>
							</tr>
							<tr>
								<td height="116" align="right" class="message_labes">内容：&nbsp;</td>
								<td><textarea name="content" class="message_input" style="height:100px;" id="content" ></textarea></td>
							</tr>
							<tr>
								<td colspan="2"><div class="msg_btn_area"> <a href="javascript:void(0);" onclick="cfm_msg();return false;">提交</a> &nbsp; <a href="<?php echo $gourl; ?>">返回</a>
									</div></td>
							</tr>
						</table>
						<input type="hidden" name="action" id="action" value="add" />
					</form>
				</div>
                <div class="clear"></div>
				<?php
				$dopage->GetPage("SELECT * FROM `#@__message` WHERE checkinfo=true",10);
				while($row = $dosql->GetArray())
				{
				?>
				<div class="message_block">
					<div class="message_title">
						<h2><?php echo $row['nickname']; ?></h2>
						<span><?php echo $row['id']; ?>#</span></div>
					<p><?php echo $row['content']; ?></p>
					<?php
					if($row['recont'] != '')
					{
					?>
					<div class="message_replay"><strong>回复/Reply：</strong><?php echo $row['recont']; ?></div>
					<?php
					}
					?>
					<div class="message_info"><?php echo GetDateTime($row['posttime']); ?> / <?php echo $row['ip']; ?></div>
				</div>
				<?php
				}
			
				?>
			</div>
                    </dd>
    </div>
  </div>
  <?php include('sidebar.php');?>
</div>
<?php include('footer.php');?>
</body>
</html>
