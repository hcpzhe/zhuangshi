<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片信息管理</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/listajax.js"></script>
<script type="text/javascript" src="templets/js/loadimage.js"></script>
<script type="text/javascript" src="templets/js/mgr.func.js"></script>
</head>
<body onload="GetList('infoimg','<?php echo ($tid = isset($tid) ? $tid : ''); ?>','<?php echo $cutover_url; ?>')">
<div class="mgr_header"> <span class="title">图片信息管理</span>
		<?php 
		if($cutover_url != 'small')
		{
		?>
		<div class="alltype" onmouseover="ShowAllType();" onmouseout="HideAllType();">
				<a href="javascript:;" onclick="GetType('','查看全部')" class="btn">查看全部</a>
				<span><?php ShowType2('#@__infoclass',2); ?></span>
		</div>
		<?php
		}
		?>
		<span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<!--/header end-->
<form name="form" id="form" method="post">
		<div id="list_area">
				<div class="loading"><img src="templets/images/loading.gif" />读取列表中...</div>
		</div>
</form>
<!--/list end-->
<div id="recycle_window">
		<div class="recycle_window_header"><span class="recycle_window_title">图片列表回收站：</span> <span class="recycle_window_close"><a href="javascript:HideRecycle()"></a></span>
				<div class="cl"></div>
		</div>
		<form id="recycleform" name="recycleform" method="post">
				<div class="recycle_list" id="recycle_list"></div>
				<div class="recycle_bottom">
						<div class="selall"><span>选择：</span> <a href="javascript:RecycleCheckAll(true);">全部</a> - <a href="javascript:RecycleCheckAll(false);">无</a> - <a href="javascript:;" onclick="RecycleReAll('resetall')">还原</a> - <a href="javascript:;" onclick="RecycleReAll('delall')">删除</a></div>
						<a href="javascript:;" onclick="RecycleReAll('empty')"><img src="templets/images/empty_recycle.png" /></a> </div>
		</form>
</div>
</body>
</html>