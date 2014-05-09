<?php
$dn = basename(realpath(dirname(__FILE__).'/../../../'));
require_once(dirname(__FILE__).'/../../../UaPlus/common.inc.php');

require_once('JSON.php');


//有上传文件时
if(!empty($_FILES))
{

	//引入上传类
	require_once(SITE_DATA.'/upload/upload.class.php');
	$upload_info = UploadFile('imgFile', true);


	/*
	 * 返回上传状态，是数组则表示上传成功
	 * 非数组则是直接返回发生的问题
	 */
	if(!is_array($upload_info))
	{
		alert($upload_info);
		exit();
	}
	else
	{
		$file_url = '../'.$upload_info[2];

		header('Content-type: text/html; charset=UTF-8');
		$json = new Services_JSON();
		echo $json->encode(array('error' => 0, 'url' => $file_url));
		exit();
	}
}

function alert($msg)
{
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit();
}
?>