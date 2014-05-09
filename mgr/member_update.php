<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改会员</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/getuploadify.js"></script>
<script type="text/javascript" src="templets/js/member_ajax.js"></script>
<script type="text/javascript" src="templets/js/checkf.func.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__member` WHERE id=$id");
?>
<div class="gray_header"> <span class="title">修改会员</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="member_save.php" onsubmit="return cfm_upmember();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<tr>
			<td width="25%" height="35" align="right">用户名：</td>
			<td width="75%"><strong><?php echo $row['username']; ?></strong></td>
		</tr>
		<tr>
			<td height="35" align="right">密　码：</td>
			<td><input type="password" name="password" id="password" class="class_input" />
				<span class="maroon">*<span class="cnote">若不修改密码请留空</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">确　认：</td>
			<td><input type="password" name="repassword" id="repassword" class="class_input" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">真实姓名：</td>
			<td><input type="text" name="truename" id="truename" class="input_short" value="<?php echo $row['truename']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">性　别：</td>
			<td><input type="radio" name="sex" value="0" <?php if($row['sex']=='0')echo 'checked'; ?> />
				男&nbsp;
				<input type="radio" name="sex" value="1" <?php if($row['sex']=='1')echo 'checked'; ?> />
				女</td>
		</tr>
		<tr>
			<td height="35" align="right">生　日：</td>
			<td><input type="text" name="birthyear" id="birthyear" class="class_input" style="width:50px;" value="<?php echo substr($row['birthdate'],0,4)?>" />
				年-
				<input type="text" name="birthmonth" id="birthmonth" class="class_input" style="width:50px;" value="<?php echo substr($row['birthdate'],5,2)?>" />
				月-
				<input type="text" name="birthday" id="birthday" class="class_input" style="width:50px;" value="<?php echo substr($row['birthdate'],8,2)?>" />
				日<span class="cnote"><span class="maroon">*</span> 格式：1986-02-14</span></td>
		</tr>
		<tr>
			<td height="35" align="right">州 / 省：</td>
			<td><input type="text" name="province" class="class_input" id="province" value="<?php echo $row['province']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">城　市：</td>
			<td><input type="text" name="city" class="class_input" id="city" value="<?php echo $row['city']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">住　址：</td>
			<td><input type="text" name="address" id="address" class="class_input" value="<?php echo $row['address']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">电　话：</td>
			<td><input type="text" name="telephone" id="telephone" class="class_input" value="<?php echo $row['telephone']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">邮　编：</td>
			<td><input type="text" name="zipcode" class="class_input" id="zipcode" value="<?php echo $row['zipcode']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="35" align="right">证件号码：</td>
			<td><select name="cardtype" id="cardtype">
					<option value="0" <?php if($row['cardtype']=='0')echo 'selected'; ?>>护照号</option>
					<option value="1" <?php if($row['cardtype']=='1')echo 'selected'; ?>>身份证</option>
				</select>
				<input type="text" name="cardnum" id="cardnum" class="class_input" style="width:174px" value="<?php echo $row['cardnum']; ?>" />
				<span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="116" align="right">个人说明：</td>
			<td><textarea name="showinfo" id="showinfo" class="class_areatext"><?php echo $row['showinfo']; ?></textarea></td>
		</tr>
		<tr>
			<td height="35" align="right">照　片：</td>
			<td><input type="text" name="picurl" id="picurl" class="class_input" value="<?php echo $row['picurl']; ?>" />
				<span class="cnote"><span class="gray_btn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span></span></td>
		</tr>
		<tr>
			<td height="35" align="right">等　级：</td>
			<td><select name="level" id="level">
					<option value="0" <?php if($row['level']=='0')echo 'selected'; ?>>初级会员</option>
					<option value="1" <?php if($row['level']=='1')echo 'selected'; ?>>高级会员</option>
				</select></td>
		</tr>
		<tr>
			<td height="35" align="right">积　分：</td>
			<td><input type="text" name="integral" class="input_short" id="integral" value="<?php echo $row['integral']; ?>" /></td>
		</tr>
		<tr>
			<td height="35" align="right">注册时间：</td>
			<td><?php echo GetDateTime($row['regtime']); ?></td>
		</tr>
		<tr class="nb">
			<td height="35" align="right">审　核：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo']=='true')echo 'checked'; ?> />
				已审核&nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo']=='false')echo 'checked'; ?>  />
				未审核</td>
		</tr>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>