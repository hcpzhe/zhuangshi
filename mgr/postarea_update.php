<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加配送区域</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__postarea` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改配送区域</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="postarea_save.php" onsubmit="return cfm_postarea();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">所属配送地区：</td>
			<td width="75%"><select name="parentid" id="parentid">
					<option value="0">一级配送地区</option>
					<?php ShowType('#@__postarea','#@__postarea','parentid'); ?>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">配送地区名称：</td>
			<td><input type="text" name="classname" id="classname" class="class_input" value="<?php echo $row['classname']; ?>" />
				<span class="maroon">*<span class="cnote">带*号表示为必填项</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">区域运费：</td>
			<td><input type="text" name="freight" id="freight" class="class_input" value="<?php echo $row['freight']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">排列排序：</td>
			<td><input type="text" name="orderid" id="orderid" class="class_input" value="<?php echo $row['orderid']; ?>" style="width:127px;" /></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">是否显示：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked'; ?> />
				显示&nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked'; ?> />
				隐藏</td>
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