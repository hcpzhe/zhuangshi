<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

$mode = isset($mode) ? $mode : 'sql';

if($mode == 'dir')
{
	$incfile = 'upload_filemgr_dir.php';
}
else
{
	$incfile = 'upload_filemgr_sql.php';
}

require_once($incfile);

?>