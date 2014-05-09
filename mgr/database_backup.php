<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据库管理</title>
<link href="templets/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/db.func.js"></script>
</head>
<body>
<?php

define('IN_BKUP', TRUE);

function ShowDataMsg($msg, $url_forward='', $ms=1000)
{
	require_once('database_message.php');
}

function DelDataDir($dirname)
{
	global $action;
	$handler = opendir($dirname);

	while(($fname = readdir($handler)) !== false)
	{
		if($fname != '.' && $fname != '..')
		{
			if(@!unlink($dirname.$fname))
			{
				ShowDataMsg("<span class='red'>删除失败，{$dirname}备份目录中可能还存在其他文件夹，请手动删除！</span>",'?action='.$action,1650);
				exit();
			}
		}
	}

	closedir($handler);
	rmdir($dirname);
}

$action = isset($action) ? $action : 'export';
$dopost = isset($dopost) ? $dopost : '';
$tbname = isset($tbname) ? $tbname : '';
$backup_dir = SITE_BACKUP.'/';

require_once('database_header.php');

switch($action)
{
	case 'export':


		//备份数据表
		if($dopost == 'backup')
		{
			if(empty($tbname))
			{
				ShowDataMsg('<span class="red">请选择要备份的数据表!</span>','?action='.$action);
				exit();
			}
			require_once('database_done.php');
			exit();
		}


		//查看表结构
		else if($dopost == 'struct')
		{
			if(empty($tbname))
			{
				ShowDataMsg('<span class="red">请选择要查看的数据表!</span>','?action='.$action);
				exit();
			}
			require_once('database_struct.php');
			exit();
		}


		//修复数据表
		else if($dopost == 'repair')
		{
			if(empty($tbname))
			{
				ShowDataMsg('<span class="red">没有指定要修复的表名!</span>','?action='.$action);
				exit();
			}

			if(is_array($tbname))
			{
				foreach($tbname as $k => $v)
				{
					$db->ExecNoneQuery("REPAIR TABLE `$v`");
				}
			}
			else
			{
				$db->ExecNoneQuery("REPAIR TABLE `$tbname`");
			}
			
			ShowDataMsg('<span class="blue">数据表修复完毕!</span>','?action='.$action);
			exit();
		}


		//优化数据表
		else if($dopost == 'optimize')
		{
			if(empty($tbname))
			{
				ShowDataMsg('<span class="red">没有指定要优化表名!</span>','?action='.$action);
				exit();
			}

			if(is_array($tbname))
			{
				foreach($tbname as $k => $v)
				{
					$db->ExecNoneQuery("OPTIMIZE TABLE `$v`");
				}
			}
			else
			{
				$db->ExecNoneQuery("OPTIMIZE TABLE `$tbname`");
			}
			
			ShowDataMsg('<span class="blue">数据表优化完毕!</span>','?action='.$action);
			exit();
		}


		//无 action 命令则展示数据表
		else
		{
			$name = $num = $size = array();
			$i = $total_size = 0;
			$db->Execute("SHOW TABLE STATUS");

			while($r = $db->GetArray())
			{
				$name[$i] = $r['Name'];
				$num[$i]    = $r['Rows'];
				$size[$i]   = GetRealSize($r['Data_length']);
				$total_size += $r['Data_length'];
				$i++;
			}

			$mysql_version = $db->GetVersion();
			require_once('database_export.php');
			exit();
		}
	break;


	case 'import':


		//还原数据
		if($dopost == 'reset')
		{
			if(empty($tbname))
			{
				ShowDataMsg('<span class="red">请选择要还原的数据表!</span>','?action='.$action);
				exit();
			}
			require_once('database_done.php');
			exit();
		}


		//删除备份目录
		else if($dopost == 'deldir')
		{
			$backup_file = $backup_dir.$tbname.'/';
			if(!file_exists($backup_file))
			{
				ShowDataMsg("<span class='red'>没有找到 $tbname 备份目录！</span>",'?action='.$action);
				exit();
			}
			else
			{
				DelDataDir($backup_file);
				ShowDataMsg("<span class='blue'>删除备份目录 $tbname 成功！</span>",'?action='.$action);
				exit();
			}
		}


		//删除全部目录
		else if($dopost == 'deldirall')
		{
			$oknum = 0;
			for($i=0; $i<count($tbname); $i++)
			{
				$backup_file = $backup_dir.$tbname[$i].'/';
				if(file_exists($backup_file))
				{
					DelDataDir($backup_file);
					$oknum++;
				}
			}
	
			ShowDataMsg("<span class='blue'>成功删除 $oknum 备份目录！</span>",'?action='.$action);
			exit();
		}


		//删除.sql文件
		else if($dopost == 'del')
		{
			$backup_file = $backup_dir.$dirname.'/'.$tbname;
			if(!file_exists($backup_file))
			{
				ShowDataMsg("<span class='red'>没有找到 $tbname 备份文件！</span>",'?action='.$action.'&dopost=sqldir&tbname='.$dirname);
				exit();
			}
			else
			{
				unlink($backup_file);
				ShowDataMsg("<span class='blue'>删除备份文件 $tbname 成功！</span>",'?action='.$action.'&dopost=sqldir&tbname='.$dirname);
				exit();
			}
		}


		//删除全部.sql文件
		else if($dopost == 'delall')
		{
			$oknum = 0;
			for($i=0; $i<count($tbname); $i++)
			{
				$backup_file = $backup_dir.$dirname.'/'.$tbname[$i];
				if(file_exists($backup_file))
				{
					unlink($backup_file);
					$oknum++;
				}
			}
	
			ShowDataMsg("<span class='blue'>成功删除 $oknum 备份文件！</span>",'?action='.$action.'&dopost=sqldir&tbname='.$dirname);
			exit();
		}


		//展示.sql文件列表
		else if($dopost == 'sqldir')
		{
			$backup_file = $backup_dir.$tbname.'/';
			if(!file_exists($backup_file))
			{
				ShowDataMsg("<span class='red'>没有找到 $tbname 备份目录！</span>",'?action='.$action);
				exit();
			}

			$backup_files = glob($backup_file.'*.txt');
			if(is_array($backup_files))
			{
				$files_size = 0;
				foreach($backup_files as $name)
				{
					$files['name'] = basename($name);
					$files['size'] = GetRealSize(filesize($name));
					$files['mktime'] = GetDateTime(filemtime($name));
					$files_size += filesize($name);
					$bfiles[] = $files;
				}
			}

			require_once('database_sqldir.php');
			exit();
		}


		//无 dopost 命令则展示备份列表
		else
		{

			$handler = opendir($backup_dir);
			$i = $total_size = 0;
			while(($fname = readdir($handler)) !== false)
			{
				if($fname != '.' && $fname != '..' && $fname != 'index.htm' && $fname != 'index.html')
				{
					$files['name'] = $fname;
					$files['mktime'] = GetDateTime(filemtime($backup_dir.$fname));

					$backup_file = glob($backup_dir.$fname.'/*.txt');
					$files_size = 0;

					foreach($backup_file as $name)
					{
						$files_size += filesize($name);
					}

					$files['size'] = GetRealSize($files_size);
					$total_size += $files_size;
					$bfiles[] = $files;
				}
				$i++;
			}

			closedir($handler);
			require_once('database_import.php');
			exit();
		}
	break;


	case 'query':


		//执行SQL语句
		if($dopost == 'runsql')
		{
			$sqlquery = trim(stripslashes($sqlquery));

			if(empty($sqlquery))
			{
				ShowDataMsg('<span class="red">请输入要执行的SQL语句。</span>','?action='.$action);
				exit();
			}

			if(preg_match("#drop(.*)table#i", $sqlquery) || preg_match("#drop(.*)database#", $sqlquery))
			{
				ShowDataMsg('<span class="red">删除\'数据表\'或\'数据库\'的语句不允许在这里执行。</span>','?action='.$action);
				exit();
			}


			//运行查询语句
			if(preg_match("#^select #i", $sqlquery) or preg_match("#^show #i", $sqlquery))
			{
				$db->Execute($sqlquery);
				if($db->GetTotalRow() <= 0)
				{
					ShowDataMsg('<span class="blue">运行SQL：{'.$sqlquery.'}，无返回记录！</span>','-1');
					exit();
				}
				else
				{
					ShowDataMsg('<span class="blue">运行SQL：{'.$sqlquery.'}，共有 '.$db->GetTotalRow().'条记录，最大返回100条！</span>','-1');
					$j = 0;
					while($row = $db->GetArray())
					{
						$j++;
						if($j > 100)
						{
							break;
						}

						echo "<div style='border-bottom:1px dotted #666;padding:10px 0;margin-bottom:8px;'>记录：$j</div>";

						foreach($row as $k=>$v)
						{
							echo "<span style='color:#900'>{$k}：</span><span style='color:#039;'>{$v}</span><br />";
						}
					}
					exit();
				}
			}


			//普通的SQL语句
			if($querytype == 2)
			{
				$sqlquery = str_replace("\r", "", $sqlquery);
				$sqls = preg_split("#;[\t]{0,}\n#", $sqlquery);
				$i = 0;
				foreach($sqls as $q)
				{
					$q = trim($q);
					if($q == '')
					{
						continue;
					}
					$db->ExecNoneQuery($q);
					$i++;
				}
				ShowDataMsg('<span class="blue">成功执行{'.$i.'}个SQL语句！</span>','?action='.$action);
				exit();
			}
			else
			{
				$db->ExecNoneQuery($sqlquery);
				ShowDataMsg('<span class="blue">成功执行1个SQL语句！</span>','?action='.$action);
				exit();
			}

		}
		else
		{
			require_once('database_query.php');
			exit();
		}
	break;

	
	default:
	break;
}
?>
</body>
</html>