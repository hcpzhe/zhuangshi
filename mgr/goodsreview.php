<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品评论管理</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">商品评论</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="review_t">
		<tr>
			<td width="5%" height="30" align="center" valign="bottom"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<?php
		$sql = "SELECT * FROM `#@__goodsreview`";
		if(isset($tid)) $sql .= " WHERE goodsid=$tid";

		$dopage->GetPage($sql);

		while($row = $dosql->GetArray())
		{
			switch($row['checkinfo'])
			{
				case 'true':
				$checkinfo = '已审';
				break;  
				case 'false':
				$checkinfo = '未审';
				break;
				default:
				$checkinfo = '没有获取到参数';
			}
		?>
		<tr align="center" class="mgr_tr">
			<td width="5%" height="60"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td width="5%"><?php echo $row['id']; ?></td>
			<td colspan="4" align="left"><?php
			$row2 = $dosql->GetOne('SELECT title FROM `#@__goods` WHERE id='.$row['goodsid']);
			?>
				<span class="titles"><span style="color:#666"><strong><?php echo GetDateTime($row['posttime']); ?></strong> 用户<strong><?php echo $row['nickname']; ?></strong> 在IP为 <strong><?php echo $row['ip']; ?></strong> 的位置对编号为 <strong><?php echo $row['goodsid']; ?></strong> 的 <strong><?php echo $row2['title']; ?></strong> 商品进行了评论：</span><br />
				<span style="color:#06F"><?php echo $row['content']; ?></span></span></td>
			<td width="18%" class="action"><span id="checkinfo<?php echo $row['id']; ?>">[<a href="goodsreview_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="goodsreview_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="goodsreview_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a>]</span></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<div class="review_b">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('goodsreview_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
	<span class="mgr_btn"><a href="goodsreview_add.php">添加商品评论</a></span> </div>
<div class="page_area"> <?php echo $dopage->GetList(); ?> </div>
</body>
</html>