<?php
$dn = basename(realpath(dirname(__FILE__).'/../../../'));
require_once(dirname(__FILE__).'/../../../UaPlus/common.inc.php');

//初始化参数
$action      = isset($action) ? $action : '';
$iswatermark = isset($iswatermark) ? $iswatermark : '';


if(!empty($_FILES))
{
	/*
	js folder传递的值，在此取消使用cfg的设置
	$folder        = $_POST['folder'];
	*/

	//引入上传类
	require_once(SITE_DATA.'/upload/upload.class.php');
	$upload_info = UploadFile('Filedata', $iswatermark);


	/*
	 * 返回上传状态，是数组则表示上传成功
	 * 非数组则是直接返回发生的问题
	 */
	if(!is_array($upload_info))
	{
		echo '{"0":0,"1":"'.$upload_info.'"}';
		exit();
	}
	else
	{
		echo json_encode($upload_info);
		exit();
	}
}


//删除元素
if($action == 'del')
{
	$dosql->ExecNoneQuery("DELETE FROM `#@__uploads` WHERE path='$filename'");
	unlink(SITE_ROOT .'/'. $filename);
	exit();
}
?>