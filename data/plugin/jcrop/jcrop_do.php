<?php
$dn = basename(realpath(dirname(__FILE__).'/../../../'));
require_once(dirname(__FILE__).'/../../../../UaPlus/common.inc.php');

//引入水印文件
require_once(SITE_DATA.'/watermark/watermark.class.php');


//初始化参数
$imgurl  = isset($imgurl) ? $imgurl : '';
$srcfile = SITE_ROOT.'/'.$imgurl;
$nwidth  = isset($iw) ? $iw : '';
$nheight = isset($ih) ? $ih : '';
$x1      = isset($x1) ? $x1 : '';
$x2      = isset($x2) ? $x2 : '';
$y1      = isset($y1) ? $y1 : '';
$y2      = isset($y2) ? $y2 : '';
$wm      = isset($wm) ? $wm : '';


//获取图片信息
$imginfo = getimagesize($srcfile);
$width   = $imginfo[0];
$height  = $imginfo[1];


//检测图片扩展名
$file_ext = substr(strrchr($imgurl, '.'), 1);
if(!in_array($file_ext, array('jpg','png','gif','bmp')))
{
	echo 'false';
}


//创建真彩图像
$thumb = imagecreatetruecolor($nwidth, $nheight);


//获取图像文件
switch($imginfo['mime'])
{
	case 'image/jpeg':
		$source = imagecreatefromjpeg($srcfile);
		break;
	case 'image/gif':
		$source = imagecreatefromgif($srcfile);
		break;
	case 'image/png':
		$source = imagecreatefrompng($srcfile);
		break;
	case 'image/wbmp':
		$source = imagecreatefromwbmp($srcfile);
		break;
	default:
		echo '对不起，裁剪图片类型不支持请选择其他类型图片！';
		break;
}


//创建图像文件
imagecopy($thumb, $source, 0, 0, $x1, $y1, $width, $height);


//生成图像文件
switch($imginfo['mime'])
{
	case 'image/jpeg':
		imagejpeg($thumb, $srcfile, 85);
		break;
	case 'image/gif':
		imagegif($thumb, $srcfile);
		break;
	case 'image/png':
		imagepng($thumb, $srcfile);
		break;
	case 'image/wbmp':
		imagewbmp($thumb, $srcfile);
		break;
	default:
		echo '对不起，裁剪图片类型不支持请选择其他类型图片！';
		break;
}


//水印设置
if($cfg_markswitch=='Y' and $wm=='true')
{
	WaterMark($srcfile, SITE_ROOT.'/'.$cfg_markpicurl, $cfg_markwhere, $cfg_marktext, SITE_DATA.'/fonts/incite.ttf', $cfg_marksize, $cfg_markcolor, $cfg_marktype);
}


//返回状态
echo true;
?>