<?php
// 输出网站所占用的磁盘空间
require(dirname(__FILE__).'/inc/config.inc.php');
echo $spaceUse = GetRealSize(GetFolderSize('../'));
?>