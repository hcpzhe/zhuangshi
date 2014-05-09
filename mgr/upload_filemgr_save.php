<?php	require(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$mode   = isset($mode)   ? $mode   : '';
$action = isset($action) ? $action : '';
$gourl  = 'upload_filemgr.php';


//判断是否为目录模式
if($mode == 'dir')
{

	//初始化参数
	$gourl    = isset($dirname)  ? 'upload_filemgr.php?mode=dir&dirname='.$dirname : 'upload_filemgr.php?mode=dir';
	$dirname  = isset($dirname)  ? $dirname  : '';
	$filename = isset($filename) ? $filename : '';


	//删除文件
	if($action == 'delfile')
	{
		$dstring = '../'.$dirname.$filename;

		if(file_exists($dstring))
		{
			if(@unlink($dstring))
			{
				header("location:$gourl");
				exit();
			}
			else
			{
				ShowMsg('未知错误，文件删除失败！', $gourl);
				exit();
			}
		}
		else
		{
			ShowMsg('在目录中未找到该文件，请尝试刷新文件列表！', $gourl);
			exit();
		}
	}
	
	
	//删除目录
	else if($action == 'deldir')
	{
		$dstring = '../'.$dirname.$filename;
	
		if(file_exists($dstring))
		{
			if(@rmdir($dstring))
			{
				header("location:$gourl");
				exit();
			}
			else
			{
				ShowMsg('未知错误，文件夹删除失败！', $gourl);
				exit();
			}
		}
		else
		{
			ShowMsg('在目录中未找到该文件，请尝试刷新文件列表！', $gourl);
			exit();
		}
	}


	//批量删除
	else if($action == 'delall')
	{
		$idsnum = count($checkid);
		$filename_arr = '';
		for($i=1; $i<$idsnum; $i++)
		{
			$filename = '../'.$dirname.$checkid[$i];
			if(file_exists($filename))
			{
				@unlink($filename);
			}
			else
			{
				$filename_arr .= $checkid[$i].'|';
			}
		}
		if($filename_arr == '')
		{
			header("location:$gourl");
			exit();
		}
		else
		{
			ShowMsg($filename_arr.'在目录中检测已不在，未进行删除操作！', $gourl);
			exit();
		}
	}

	else
	{
		header("location:$gourl");
		exit();
	}
}


//判断是否为数据模式
else if($mode == 'sql')
{

	//初始化参数
	$gourl = 'upload_filemgr.php?mode=sql';
	$path  = isset($path)  ? $path  : '';


	//删除文件
	if($action == 'del')
	{
		$dstring = '../'.$path;

		$dosql->ExecNoneQuery("DELETE FROM `#@__uploads` WHERE id=$id");

		if(file_exists($dstring))
		{
			if(@unlink($dstring))
			{
				header("location:$gourl");
				exit();
			}
			else
			{
				ShowMsg('未知错误，文件删除失败！', $gourl);
				exit();
			}
		}
		else
		{
			ShowMsg('在目录中未找到该文件，请尝试刷新文件列表！', $gourl);
			exit();
		}
	}

	//批量删除
	else if($action == 'delall')
	{
		$idsnum = count($checkid);
		$filename_arr = '';

		for($i=1; $i<$idsnum; $i++)
		{
			$dosql->ExecNoneQuery("DELETE FROM `#@__uploads` WHERE path='$checkid[$i]'");

			$filename = '../'.$checkid[$i];
			if(file_exists($filename))
			{
				@unlink($filename);
			}
			else
			{
				$filename_arr .= $checkid[$i].'|';
			}
		}

		if($filename_arr == '')
		{
			header("location:$gourl");
			exit();
		}
		else
		{
			ShowMsg($filename_arr.'在目录中检测已不在，未进行删除操作！', $gourl);
			exit();
		}
	}
	
	else
	{
		header("location:$gourl");
		exit();
	}
}
	

//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>