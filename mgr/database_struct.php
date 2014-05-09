<?php if(!defined('IN_BKUP')) exit("请从正确的路径访问！"); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table">
	<tr align="center" class="thead2">
		<td width="20%" height="25">字段[备注]</td>
		<td>类型(长度)</td>
		<td>整理</td>
		<td>允许为空</td>
		<td>默认值</td>
		<td>额外</td>
	</tr>
	<?php
	$db->Execute("show full columns from `$tbname`");
	$j = 0;
	while($r = $db->GetArray())
	{
	?>
	<tr align="center" class="mgr_tr" onmouseover="this.className='mgr_tr_on'" onmouseout="this.className='mgr_tr'">
		<td height="30"><?php echo $r['Field'];if($r['Key'] == 'PRI') echo ' <img src="templets/images/database_key.gif" title="主键" />'; ?></td>
		<td><?php echo $r['Type']; ?></td>
		<td><?php echo $r['Collation'];?></td>
		<td><?php if($r['Null'] == 'NO'){echo '否';} else{echo '是';}  ?></td>
		<td><?php if($r['Default'] == ''){echo '无';} else{echo $r['Default'];} ?></td>
		<td><?php echo $r['Extra']; ?></td>
	</tr>
	<?php
		$j++;
	}
	?>
</table>
<div class="mgr_divb"> </div>
<div class="page_area">
	<div class="page_info">共<span><?php echo $j; ?></span>个字段</div>
</div>
