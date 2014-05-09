<?php
$dn = basename(realpath(dirname(__FILE__).'/../../../'));
require_once(dirname(__FILE__).'/../../../UaPlus/common.inc.php');

//初始化参数
$size  = isset($size) ? $size : '';
$num   = isset($num) ? $num : '';
$input = isset($input) ? $input : '';
$area  = isset($area) ? $area : '';
$frame = isset($frame) ? $frame : '';
$title = isset($title) ? $title : '';
$type  = isset($type) ? $type : '';


//获取上传文件类型
function GetUpType($type='')
{
	global $cfg_upload_img_type,$cfg_upload_soft_type,$cfg_upload_media_type;

	if($type == 'image')
	{
		$uptype = explode('|',$cfg_upload_img_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}
	else if($type == 'soft')
	{
		$uptype = explode('|',$cfg_upload_soft_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}
	else if($type == 'media')
	{
		$uptype = explode('|',$cfg_upload_media_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}
	else if($type == 'all')
	{
		$alltype = $cfg_upload_img_type.'|'.$cfg_upload_soft_type.'|'.$cfg_upload_media_type;
		$uptype  = explode('|',$alltype);
		$upstr   = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}
	else
	{
		return $type;
	}
}


//获取上传文件描述
function GetUpDesc($desc)
{
	global $cfg_upload_img_type,$cfg_upload_soft_type,$cfg_upload_media_type;

	if($desc == 'image')
	{
		$uptype = explode('|',$cfg_upload_img_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return '图像类型:('.$upstr.')';
	}
	else if($desc == 'soft')
	{
		$uptype = explode('|',$cfg_upload_soft_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return '软件类型:('.$upstr.')';
	}
	else if($desc == 'media')
	{
		$uptype = explode('|',$cfg_upload_media_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return '媒体类型:('.$upstr.')';
	}
	else if($desc == 'all')
	{
		$alltype = $cfg_upload_img_type.'|'.$cfg_upload_soft_type.'|'.$cfg_upload_media_type;
		$uptype  = explode('|',$alltype);
		$upstr   = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return '所有类型:('.$upstr.')';
	}
	else
	{
		return $desc;
	}
}

//引入水印配置文件
require_once(SITE_DATA.'/watermark/watermark.inc.php');


//引入HTML文件
require_once('index.html');