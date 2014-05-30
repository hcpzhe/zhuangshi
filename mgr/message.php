<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言管理</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/message_ajax.js"></script>
<script type="text/javascript" src="templets/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">留言管理</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="message_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr align="center" class="thead">
			<td width="3%" height="30" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="4%">编号</td>
			<td width="8%">姓名</td>
			<td width="8%">联系方式</td>
			<td width="8%">类型</td>
			<td width="8%">预算</td>
			<td width="23%" align="left">留言内容</td>
			<td width="17%">提交时间</td>
			<td width="21%">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__message`");

		while($row = $dosql->GetArray())
		{
			$content = $row['content'];
			$content .='<span class="titflag" id="tit_'.$row['id'].'">';
			if($row['htop'] == 'true') $content .= '置顶 ';
			if($row['rtop'] == 'true') $content .= '推荐 ';
			if($row['recont'] != '') $content .= '[已回复]';
			$content .= '</span>';
	
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
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['nickname']; ?></td>
			<td><?php echo $row['contact']; ?></td>
			<td><?php echo $row['msgtype']; ?></td>
			<td><?php echo $row['yusuan']; ?></td>
			<td align="left" class="titles"><?php echo $content; ?></td>
			<td class="number"><?php echo GetDateTime($row['posttime']); ?></td>
			<td class="action"><span id="checkinfo<?php echo $row['id']; ?>">[<a href="message_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a>]</span><span>[<a href="javascript:;" onclick="ShowReWin(<?php echo $row['id'] ?>)" rel="<?php echo $row['recont']; ?>" id="recont_<?php echo $row['id'] ?>">回复</a>]</span><span>[<a href="message_update.php?id=<?php echo $row['id']; ?>">修改</a>]</span><span>[<a href="message_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<div class="mgr_divb">
	<div class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('message_save.php');" onclick="return ConfDelAll(0);">删除</a></div>
	<span class="mgr_btn"><a href="message_add.php">添加新留言</a></span>
</div>
<div class="page_area"> <?php echo $dopage->GetList(); ?> </div>
</body>
</html>