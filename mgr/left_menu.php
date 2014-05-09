<?php require(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧菜单</title>
<link href="templets/style/menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/tinyscrollbar.js"></script>
<script type="text/javascript" src="templets/js/leftmenu.js"></script>
</head>
<body>
<div class="quickbtn"> <span class="quickbtn_left"><a href="infolist_add.php" target="main">添加列表</a></span> <span class="quickbtn_right"><a href="infoimg_add.php" target="main">添加图片</a></span> </div>
<div class="tGradient"></div>
<div id="scrollmenu">
	<div class="scrollbar">
		<div class="track">
			<div class="thumb">
				<div class="end"></div>
			</div>
		</div>
	</div>
	<div class="viewport">
		<div class="overview">
			<!--scrollbar start-->
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu01');" title="点击进行显示隐藏操作"> 网站系统管理 </div>
				<div id="leftmenu01"> <a href="admin.php" target="main">管理员管理</a> <a href="web_config.php" target="main">网站信息配置</a> <a href="upload_filemgr.php" target="main">上传文件管理</a><a href="database_backup.php" target="main">数据库管理</a> </div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu02');" title="点击进行显示隐藏操作"> 网站模块配置 </div>
				<div id="leftmenu02" style="display:none"> <a href="infoclass.php" target="main">栏目管理</a><a href="maintype.php" target="main">二级类别管理</a>
					<div class="hr_1"> </div>
					<a href="info.php" target="main">单页信息管理</a> <a href="infolist.php" target="main">列表信息管理</a> <a href="infoimg.php" target="main">图片信息管理</a> <a href="soft.php" target="main">软件下载管理</a>
					<div class="hr_1"> </div>
					<a href="admanage.php" target="main">广告模块管理</a> <a href="weblink.php" target="main">友情链接管理</a> <a href="member.php" target="main">会员模块管理</a> <a href="message.php" target="main">留言模块管理</a> <a href="job.php" target="main">招聘信息管理</a> <a href="vote.php" target="main">投票模块管理</a>
					<div class="hr_1"> </div>
					<a href="diymenu.php" target="main">自定义菜单项</a> <a href="diyfield.php" target="main">自定义字段</a> <a href="infoflag.php" target="main" title="信息标记管理" class="infoattr"></a> <a href="adtype.php" target="main" title="广告位管理" class="adtype"></a> <a href="weblinktype.php" target="main" title="友情链接类别" class="weblinktype"></a> </div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu05');" title="点击进行显示隐藏操作"> 商品订单管理 </div>
				<div id="leftmenu05" style="display:none"> <a href="goodstype.php" target="main">商品类别管理</a> <a href="goodsattr.php" target="main">商品属性管理</a><a href="goodsbrand.php" target="main">品牌类型管理</a> <a href="goodsflag.php" target="main" title="商品信息属性管理" class="goodsinfoattr"></a>
					<div class="hr_1"> </div>
					<a href="goods.php" target="main">商品列表管理</a> <a href="goodsreview.php" target="main">商品评论管理</a>
					<div class="hr_1"> </div>
					<a href="goodsorder.php" target="main">订单列表管理</a> <a href="postarea.php" target="main">配送地区管理</a> <a href="postmode.php" target="main">配送方式管理</a> <a href="paymode.php" target="main">支付方式管理</a><a href="getmode.php" target="main">货到方式管理</a> </div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu06');" title="点击进行显示隐藏操作"> 界面模板管理 </div>
				<div id="leftmenu06" style="display:none;"> <a href="nav.php" target="main">导航菜单设置</a>
					<div class="hr_1"> </div>
					<a href="editfile.php" target="main">默认模板管理</a> </div>
			</div>
			<div class="hr_5"></div>
			<div class="menubox">
				<div class="title" onclick="DisplayMenu('leftmenu04');" title="点击进行显示隐藏操作"> 帮助与更新 </div>
				<div id="leftmenu04" style="display:none;"> <a href="upload_file.php" target="main">上传新文件</a>
					<div class="hr_1"> </div>
					<a href="check_bom.php" target="main">BOM检查</a> <a href="help.php" target="main">开发帮助</a> </div>
			</div>
			<!--scrollbar end-->
		</div>
	</div>
</div>
<div class="bGradient"></div>
<div class="hr_5"></div>
<div class="copyright"> © 2012<br />All Rights Reserved. </div>
</body>
</html>