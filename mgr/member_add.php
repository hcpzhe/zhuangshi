<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员注册</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/getuploadify.js"></script>
<script type="text/javascript" src="templets/js/member_ajax.js"></script>
<script type="text/javascript" src="templets/js/checkf.func.js"></script>
</head>
<body>
<div class="gray_header"> <span class="title">注册会员</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="member_save.php" onsubmit="return cfm_member();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">用户名：</td>
			<td width="75%"><input type="text" name="username" id="username" class="class_input" onblur="CheckUser();" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span> <span id="usernote"></span>
				<input type="hidden" id="isuser" name="isuser" value="" /></td>
		</tr>
		<tr>
			<td height="35" align="right">密　码：</td>
			<td><input name="password" type="password" id="password" class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">确　认：</td>
			<td><input name="repassword" type="password" id="repassword" class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">真实姓名：</td>
			<td><input name="truename" type="text" id="truename" class="input_short" /></td>
		</tr>
		<tr>
			<td height="35" align="right">性　别：</td>
			<td><input name="sex" type="radio" value="0" checked="checked"  />
				男&nbsp;
				<input name="sex" type="radio" value="1"  />
				女</td>
		</tr>
		<tr>
			<td height="35" align="right">生　日：</td>
			<td><input type="text" name="birthyear" id="birthyear" class="input_shortb" style="width:50px;" />
				年-
				<input name="birthmonth" type="text" id="birthmonth" class="class_input" style="width:50px;" />
				月-
				<input name="birthday" type="text" id="birthday" class="class_input" style="width:50px;" />
				日</td>
		</tr>
		<tr>
			<td height="35" align="right">照　片：</td>
			<td><input name="picurl" type="text" id="picurl" class="class_input" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">州 / 省：</td>
			<td><input type="text" name="province" id="province" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">城　市：</td>
			<td><input type="text" name="city" id="city" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">住　址：</td>
			<td><input type="text" name="address" id="address" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">电　话：</td>
			<td><input type="text" name="telephone" id="telephone" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">邮　编：</td>
			<td><input type="text" name="zipcode" id="zipcode" class="class_input" /></td>
		</tr>
		<tr>
			<td height="35" align="right">证件号码：</td>
			<td><select name="cardtype" id="cardtype">
					<option value="0">身份证</option>
					<option value="1">护照号</option>
				</select>
				<input type="text" name="cardnum" id="cardnum" class="class_input" style="width:174px" /></td>
		</tr>
		<tr>
			<td height="116" align="right">个人说明：</td>
			<td><textarea name="showinfo" id="showinfo" class="class_areatext"></textarea></td>
		</tr>
		<tr>
			<td height="35" align="right">等　级：</td>
			<td><select name="level" id="level">
					<option value="0">初级会员</option>
					<option value="1">高级会员</option>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">积　分：</td>
			<td><input name="integral" type="text" class="input_short" id="integral" value="0" /></td>
		</tr>
		<tr>
			<td height="35" align="right">注册时间：</td>
			<td><input type="text" name="regtime" id="regtime" class="input_short" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript" src="../data/plugin/calendar/calendar.js"></script>
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "regtime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input name="checkinfo" type="radio" value="true" checked="checked"  />
				已审核&nbsp;
				<input name="checkinfo" type="radio" value="false"  />
				未审核</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" id="regip" name="regip" value="<?php echo GetIP(); ?>" />
		<input name="action" type="hidden" id="action" value="add" />
	</div>
</form>
</body>
</html>