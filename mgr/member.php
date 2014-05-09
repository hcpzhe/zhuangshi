<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员管理</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/loadimage.js"></script>
<script type="text/javascript" src="templets/js/mgr.func.js"></script>
<script type="text/javascript">
$(function(){
    $(".memberpic img").LoadImage({height:40});
});
</script>
</head>
<body>
<div class="mgr_header"> <span class="title">会员管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="member_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td height="30" width="5%"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="10%">头像</td>
			<td width="5%">ID</td>
			<td>用户名</td>
			<td>性别</td>
			<td>电话</td>
			<td>等级</td>
			<td>积分</td>
			<td width="18%">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__member`");

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
			<td><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td height="50"><span class="memberpic"><img alt="<?php if($row['picurl'] == ''){echo 'templets/images/user_default_photo.jpg';}else{echo '../'.$row['picurl'];} ?>" /></span></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['username']; ?></td>
			<td><?php if($row['sex'] == '0'){echo '男';}else{echo '女';} ?></td>
			<td><?php echo $row['telephone']; ?></td>
			<td class="mgr_action"><?php switch($row['level']){case '0':echo '初级会员';break;case '1':echo '高级会员';break;default:echo '没有获取到参数';break;} ?></td>
			<td><?php echo $row['integral']; ?></td>
			<td class="action"><span id="checkinfo<?php echo $row['id']; ?>">[<a href="member_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="member_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="member_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a>]</span></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<div class="mgr_divb">
	<span class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('member_save.php');" onclick="return ConfDelAll(0);">删除</a></span>
	<span class="mgr_btn"><a href="member_add.php">注册新会员</a></span> </div>
<div class="page_area">
	<?php echo $dopage->GetList(); ?>
</div>
</body>
</html>