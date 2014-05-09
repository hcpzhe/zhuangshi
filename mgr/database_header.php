<?php if(!defined('IN_BKUP')) exit("请从正确的路径访问！"); ?>

<div class="mgr_header"><span class="title">数据库管理</span>
	<?php
	if($dopost == 'struct') echo "<span class='header_text'>[表结构：<a href='?action=$action'>$tbname</a>]</span>";
	if($dopost == 'sqldir') echo "<span class='header_text'>目录：<a href='?action=$action'>/$tbname/</a></span>";
	?> <span class="reload"><a href="javascript:location.reload();">刷新</a></span></div>
<div class="mgr_divt">
	<ul class="flag">
		<li>属性：</li>
		<li <?php if($action == 'export') echo 'class="db_action"'; ?>><a href="?action=export">数据库操作</a></li>
		<li><span>|</span></li>
		<li <?php if($action == 'import') echo 'class="db_action"'; ?>><a href="?action=import">数据库还原</a></li>
		<li><span>|</span></li>
		<li <?php if($action == 'query') echo 'class="db_action"'; ?>><a href="?action=query">执行SQL语句</a></li>
	</ul>
</div>
