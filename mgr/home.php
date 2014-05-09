<?php	require(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".notewarn").fadeIn();
	$(".notewarn .close a").click(function(){
		$(".notewarn").fadeOut();
	});
});
</script>
</head>
<body>
<div class="home_header">
	<div class="refurbish"><span class="title">管理中心</span><span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
</div>
<div class="main_area">
	<div class="main_l">
		<div class="main_l_left">
			<div class="weladmin"> <span>Hi,</span> <strong><?php echo $_SESSION['admin']; ?></strong></div>
			<div class="logininfo">您上次登录的时间：<span><?php echo GetDateTime($_SESSION['lastlogintime']); ?></span><br />
				您上次登录的IP：<span><?php echo $_SESSION['lastloginip']; ?></span> <span><a href="admin_update.php?id=<?php $row = $dosql->GetOne("SELECT id FROM `#@__admin` WHERE username='".$_SESSION['admin']."'");echo $row['id'];?>" class="uppwd">修改密码</a></span></div>
			<div class="cl"></div>
			<div class="siteinfo">
				<h2 class="title">系统信息</h2>
				<?php
				function ShowResult($revalue)
				{
					if($revalue == 1) return '<span class="ture">支持</span>';
					else return '<span class="flase">不支持</span>';
				}
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="home_table">
					<tr>
						<td height="28" colspan="2">软件版本号： <?php echo $cfg_version.' ('.$db_charset.')';?></td>
					</tr>
					<tr>
						<td width="50%" height="28">服务器名称： <span title="<?php echo $_SERVER["SERVER_NAME"]; ?>"><?php echo ReStrLen($_SERVER["SERVER_NAME"],7); ?></span></td>
						<td width="50%">操作系统： <?php echo PHP_OS; ?></td>
					</tr>
					<tr>
						<td height="28">服务器版本： <span title="<?php echo $_SERVER["SERVER_SOFTWARE"]; ?>"><?php echo ReStrLen($_SERVER["SERVER_SOFTWARE"],7) ?></span></td>
						<td>GDLibrary： <?php echo ShowResult(function_exists("imageline")); ?></td>
					</tr>
					<tr>
						<td height="28">PHP版本号： <?php echo PHP_VERSION?></td>
						<td>ZEND支持： <?php echo ShowResult(function_exists("zend_version")); ?></td>
					</tr>
					<tr>
						<td height="28">MySQL版本： <?php echo $dosql->GetVersion(); ?></td>
						<td height="28">支持上传的最大文件：<?php echo ini_get('upload_max_filesize'); ?></td>
					</tr>
					<tr class="nb">
						<td height="28">空间使用量：<a href="javascript:;" title="点击查看" id="folderSize">[点击查看]</a>
						<script type="application/javascript">
							$('#folderSize').click(function(){
								$(this).html('正在查询..');
								$.get("space.js.php", function(data){
									$('#folderSize').html(data);
								})
							});
						</script>
						</td>
						<td height="28">数据库使用量：<?php echo GetRealSize(GetMysqlSize());?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="main_l_right">
			<h2 class="lnktitle">快捷操作</h2>
			<div class="lnkarea">
				<div class="lnkarea_btn">[<a href="lnk.php">管理</a>]</div>
				<div class="lnkarea_btns">
					<?php
					$dosql->Execute("SELECT * FROM `#@__lnk` ORDER BY orderid ASC LIMIT 0, 8");
					while($row = $dosql->GetArray())
					{
						echo '<a href="'.$row['lnklink'].'"><img src="'.$row['lnkico'].'" />'.$row['lnkname'].'</a>';
					}
					?>
				</div>
			</div>
			<div class="countinfo">
				<h2 class="title">信息统计</h2>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="home_table">
					<tr>
						<td width="80" height="28">网站栏目数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__infoclass'); ?></td>
					</tr>
					<tr>
						<td height="28">列表信息数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__infolist'); ?></td>
					</tr>
					<tr>
						<td height="28">图片信息数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__infoimg'); ?></td>
					</tr>
					<tr>
						<td height="28">商品信息数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__goods'); ?></td>
					</tr>
					<tr>
						<td height="28">商品订单数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__goodsorder'); ?></td>
					</tr>
					<tr class="nb">
						<td height="28">注册会员数：</td>
						<td class="num"><?php echo $dosql->GetTableRow('#@__member'); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="main_r">
		<div class="main_r_dev">
			<div class="title">注意事项</div>
			<ul class="cont">
				<li>1、网站栏目、模块请勿随意改名或删除，这有可能导致前后台显示数据不统一。</li>
				<li>2、如果您需要调整栏目请联系我们的客服人员。</li>
				<li>3、栏目内的文章内容您可以自由删除、修改、增加。</li>
				<li class="btn"><a href="help.php" class="devhelp">开发帮助</a><a href="http://www.wqit.net/" target="_blank" class="fbmsg">关于我们</a></li>
			</ul>
		</div>
	</div>
	<div class="cl"></div>
</div>
<div class="notewarn"> <span class="close"><a href="javascript:;"></a></span>
	<div>显示分辨率 1360*768 显示效果最佳，建议使用新版浏览器。</div>
</div>
</body>
</html>