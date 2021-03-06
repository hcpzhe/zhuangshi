<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改商品评论</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__goodsreview` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改商品评论</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="goodsreview_save.php" onsubmit="return cfm_review();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">商　　品：</td>
			<td width="75%"><select name="goodsid" id="goodsid">
					<option value="-1">请选择评论商品</option>
					<?php ShowListInfo('#@__goods','#@__goodsreview','goodsid'); ?>
				</select>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="35" align="right">昵　　称：</td>
			<td><input type="text" name="nickname" class="class_input" id="nickname" style="width:127px;" value="<?php echo $row['nickname']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td height="116" align="right">评论内容：</td>
			<td><textarea name="content" id="content" class="class_areatext"><?php echo $row['content']; ?></textarea>
				<span class="maroon">*</span></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" class="input_short" value="<?php echo $row['orderid']; ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">更新时间：</td>
			<td><input type="text" name="posttime" class="input_short" id="posttime" value="<?php echo GetDateTime($row['posttime']); ?>" readonly="readonly" />
				<script type="text/javascript" src="../data/plugin/calendar/calendar.js"></script>
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked'; ?> />
				是 &nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked'; ?> />
				否<span class="cnote">选择“否”则该信息暂时不显示在前台</span></td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" onclick="history.go(-1)" value=""  />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>