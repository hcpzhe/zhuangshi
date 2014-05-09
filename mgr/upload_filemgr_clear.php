<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传文件管理</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/jquery.min.js"></script>
<script type="text/javascript" src="templets/js/mgr.func.js"></script>
</head>
<body>
<div class="mgr_header"> <span class="title">上传文件管理</span> <span class="header_text">[<a href="upload_filemgr.php?mode=sql" class="topdir">返回数据模式</a>]</span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="">
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
		<tr class="thead" align="center">
			<td width="5%" height="30"><input type="checkbox" name="checkid[]" id="checkid[]" onclick="CheckAll(this.checked);" /></td>
			<td width="20%">文件名称</td>
			<td width="15%">文件类型</td>
			<td width="15%">上传日期</td>
			<td width="15%">文件大小</td>
			<td width="15%">使用状态</td>
			<td width="15%">操作</td>
		</tr>
		<?php

		$tb_array = array(
			'admanage'   => array('picurl'),
			'goods'      => array('picurl', 'content', 'picarr'),
			'goodsbrand' => array('picurl'),
			'goodstype'  => array('picurl'),
			'info'       => array('picurl', 'content'),
			'infoclass'  => array('picurl'),
			'infoimg'    => array('picurl', 'content', 'picarr'),
			'infolist'   => array('picurl', 'content', 'picarr'),
			'job'        => array('content'),
			'soft'       => array('picurl', 'content', 'picarr'),
			'member'     => array('picurl'),
			'message'    => array('content'),
			'nav'        => array('picurl'),
			'weblink'    => array('picurl')
		);
		
		
		$fl_str = '';
		
		foreach($tb_array as $k=>$tbname)
		{
			foreach($tbname as $field)
			{

				$dosql->Execute("SELECT `$field` FROM `#@__$k`");
				while($row = $dosql->GetArray())
				{
					if($field == 'content')
					{
						preg_match('/<img.+src=\"?(.+\.('.$cfg_upload_img_type.'))\"?.+>/i', $row[$field], $match);
						if(!empty($match[1]))
						{
							$fl_str .= $match[1].',';
						}

						preg_match('/<embed.+src=\"?(.+\.('.$cfg_upload_media_type.'))\"?.+>/i', $row[$field], $match);
						if(!empty($match[1]))
						{
							$fl_str .= $match[1].',';
						}

						preg_match('/<a.+href=\"?(.+\.('.$cfg_upload_soft_type.'))\"?.+>\//i', $row[$field], $match);
						if(!empty($match[1]))
						{
							$fl_str .= $match[1].',';
						}
					}
					else
					{
						$fl_str .= $row[$field].',';
					}

				}
			}
		}


		$dosql->Execute("SELECT * FROM `#@__uploads` ORDER BY id DESC");
		$i = 0;
		while($row = $dosql->GetArray())
		{
			if(!strpos($fl_str,$row['path']))
			{
		?>
		<tr align="center" class="mgr_tr">
			<td height="30"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['path']; ?>" /></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['type']; ?></td>
			<td class="number"><span><?php echo GetDateTime($row['posttime']); ?></span></td>
			<td><?php echo GetRealSize($row['size']); ?></td>
			<td>未使用</td>
			<td class="action"><span>[<a href="../<?php echo $row['path']; ?>" target="_blank">预览</a>]</span><span>[<a href="upload_filemgr_save.php?mode=sql&action=del&id=<?php echo $row['id']; ?>&path=<?php echo $row['path']; ?>" onclick="return ConfDel(0);">删除</a>]</span></td>
		</tr>
		<?php
				$i++;
			}
		}
		
		$fl_str = '';
		?>
	</table>
</form>
<div class="mgr_divb"> <span class="selall"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('upload_filemgr_save.php','&mode=sql');" onclick="return ConfDelAll(0);">删除</a></span></div>
<div class="page_area">
<div class="page_info">共<span>1</span>页<span><?php echo $i; ?></span>条记录</div>
</div>
</body>
</html>