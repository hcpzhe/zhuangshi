<?php	if(!defined('IN_BKUP')) exit("请从正确的路径访问！");

@ob_start();
@set_time_limit(0);


function RpLine($str)
{
	$str = str_replace("\r", "\\r", $str);
	$str = str_replace("\n", "\\n", $str);
	return $str;
}

function PutInfo($msg1,$msg2='')
{
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mgr_table"><tr align="center" class="mgr_tr"><td height="200">'.$msg1.$msg2.'</td></tr></table><div class="mgr_divb"></div>';
}


//跳转到一下页的Js

$dojs = "<script type='text/javascript'>
function GotoNextPage(){
    document.gonext.submit();
}
setTimeout('GotoNextPage()',500);
</script>";

$donejs = "<script type='text/javascript'>
function redirect(url){
	location.href = url;
}
setTimeout(\"redirect('?action=$action')\", 1000);
</script>";





if($dopost == 'backup')
{

	$tmsg = '<div class="loading" style="width:140px;margin:0;"><img src="templets/images/loading.gif">正在执行备份操作...</div><br />';

	//第一次跳转应该是属于形式，之后就变成了字符形式
	if(!is_array($tbname))
	{
		$tbname = explode(',', $tbname);
	}
	$tables = implode(',', $tbname);

	//设置此次备份的时间目录
	if(empty($backup_date))
	{
		$backup_date = 'backup_'.MyDate('Y_mdHis',time()).'_'.substr(md5(mt_rand(1000,5000)), 0, 7);
		mkdir($backup_dir .= $backup_date);
	}
	else
	{
		$backup_dir .= $backup_date;
	}
	
	//表结构是否备份
	if(!isset($isstruct))
	{
		$isstruct = 0;
	}

	//当前分卷号
	if(!isset($startpos))
	{
		$startpos = 0;
	}

	//当前备份表
	if(empty($nowtable))
	{
		$nowtable = '';
	}

	//分卷大小
	if(empty($fsize))
	{
		$fsize = 2048;
	}
	$fsizeb = $fsize * 1024;

	if($nowtable == '')
	{
	
		//如果备份表结构，则执行
		if($isstruct == 1)
		{
			$backup_file = $backup_dir.'/table_struct_'.substr(md5(mt_rand(1000,5000)), 0, 10).'.txt';
			$mysql_version = $db->GetVersion();
	
			$fp = fopen($backup_file, 'w');
			foreach($tbname as $t)
			{
				fwrite($fp, "DROP TABLE IF EXISTS `$t`;\r\n\r\n");
				$db->Execute("SHOW CREATE TABLE ".$db->db_name.".".$t);
				$row = $db->GetArray('me', MYSQL_BOTH);
	
				//去除AUTO_INCREMENT
				$row[1] = preg_replace("#AUTO_INCREMENT=([0-9]{1,})[ \r\n\t]{1,}#i", "", $row[1]);
	
				//4.1以下版本备份为低版本
				if($datatype == 4.0 && $mysql_version > 4.0)
				{
					$eng1 = "#ENGINE=MyISAM[ \r\n\t]{1,}DEFAULT[ \r\n\t]{1,}CHARSET=$cfg_charset#i";
					$tbnametruct = preg_replace($eng1, "TYPE=MyISAM", $row[1]);
				}
	
				//4.1以上版本备份为高版本
				else if($datatype == 4.1 && $mysql_version < 4.1)
				{
					$eng1 = "#ENGINE=MyISAM DEFAULT CHARSET={$cfg_charset}#i";
					$tbnametruct = preg_replace("TYPE=MyISAM", $eng1, $row[1]);
				}

				//普通备份
				else
				{
					$tbnametruct = $row[1];
				}
				fwrite($fp, $tbnametruct.";\r\n\r\n");
			}
	
			fclose($fp);
			$tmsg .= "<span class='blue'>数据表结构备份完成...</span><br /><br />";;
	
		}
		
		$tmsg .= "<span class='blue'>正在进行数据备份的初始化工作，请稍后...</span>";
		$doform = "<form name='gonext' method='post' action='?action=$action'>
		<input type='hidden' name='dopost' value='backup' />
		<input type='hidden' name='isstruct' value='$isstruct' />
		<input type='hidden' name='fsize' value='$fsize' />
		<input type='hidden' name='tbname' value='$tables' />
		<input type='hidden' name='nowtable' value='$tbname[0]' />
		<input type='hidden' name='startpos' value='0' />
		<input type='hidden' name='backup_date' value='$backup_date' /></form>
		$dojs";
		PutInfo($tmsg, $doform);
		exit();
	}
	
	
	//开始备份表数据
	else
	{
		$j = 0;
		$fs = $bakstr = '';

		//分析表里的字段信息
		$db->GetTableFields($nowtable);
		$intable = "INSERT INTO `$nowtable` VALUES(";
		while($r = $db->GetFieldObject())
		{
			$fs[$j] = trim($r->name);
			$j++;
		}
		$fsd = $j-1;

		//读取表的内容
		$m = 0;
		$backup_file = "$backup_dir/{$nowtable}_{$startpos}_".substr(md5(time().mt_rand(1000,5000)),0,6).'.txt';
	
		$db->Execute("SELECT * FROM `$nowtable`");
		while($row2 = $db->GetArray())
		{
			if($m < $startpos)
			{
				$m++;
				continue;
			}
	
			//检测数据是否达到规定大小
			if(strlen($bakstr) > $fsizeb)
			{
				$fp = fopen($backup_file,'w');
				fwrite($fp,$bakstr);
				fclose($fp);
	
				$tmsg .= "<span class='red'>完成到{$m}条记录的备份，继续备份{$nowtable}表...</span>";
				$doform = "<form name='gonext' method='post' action='?action=$action'>
				<input type='hidden' name='dopost' value='backup' />
				<input type='hidden' name='isstruct' value='$isstruct' />
				<input type='hidden' name='fsize' value='$fsize' />
				<input type='hidden' name='tbname' value='$tables' />
				<input type='hidden' name='nowtable' value='$nowtable' />
				<input type='hidden' name='startpos' value='$m'>
				<input type='hidden' name='backup_date' value='$backup_date' /></form>
				$dojs";
				PutInfo($tmsg,$doform);
				exit();
			}
	
			//正常情况
			$line = $intable;
			for($j=0; $j<=$fsd; $j++) //形成插入样式
			{
				if($j < $fsd)
				{
					$line .= "'".RpLine(addslashes($row2[$fs[$j]]))."',";
				}
				else
				{
					$line .= "'".RpLine(addslashes($row2[$fs[$j]]))."');\r\n";
				}
			}
			$m++;
			$bakstr .= $line;
	
		}
	
		//如果数据比卷设置值小
		if($bakstr != '')
		{
			$fp = fopen($backup_file, 'w');
			fwrite($fp, $bakstr);
			fclose($fp);
		}
	
		for($i=0; $i<count($tbname); $i++)
		{
			if($tbname[$i] == $nowtable)
			{
				if(isset($tbname[$i+1]))
				{
					$nowtable = $tbname[$i+1];
					$startpos = 0;
					break;
				}
				else
				{
					PutInfo("<strong class='blue'>完成所有数据备份！</strong><br /><br /><a href='?action=$action'>[如果您的浏览器没有自动跳转，请点击这里]</a>",$donejs);
					exit();
				}
			}
		}
	
		$tmsg .= "<span class='red'>完成到{$m}条记录的备份，继续备份{$nowtable}表...</span>";
		$doform = "<form name='gonext' method='post' action='?action=$action'>
		<input type='hidden' name='dopost' value='backup' />
		<input type='hidden' name='isstruct' value='$isstruct' />
		<input type='hidden' name='fsize' value='$fsize' />
		<input type='hidden' name='tbname' value='$tables' />
		<input type='hidden' name='nowtable' value='$nowtable' />
		<input type='hidden' name='startpos' value='$startpos'>
		<input type='hidden' name='backup_date' value='$backup_date' /></form>
		$dojs";
		PutInfo($tmsg,$doform);
		exit();
		//分页备份代码结束
	}
}

if($dopost == 'reset')
{

	$tmsg = '<div class="loading" style="width:160px;margin:0;"><img src="templets/images/loading.gif">正在准备还原其它数据...</div><br />';
	$backup_dir_in = $backup_dir.$dirname.'/';
	
	//第一次跳转应该是数组形式，之后就变成了字符形式
	if(!is_array($tbname))
	{
		$bakfiles = explode(',', $tbname);
	}
	else
	{
		$bakfiles = $tbname;
	}

	foreach($bakfiles as $fname)
	{
		if(!preg_match("#txt$#", $fname))
		{
			continue;
		}
		if(preg_match("#table_struct#", $fname))
		{
			$structfile = $fname;
		}
		else if(filesize($backup_dir_in.$fname) > 0)
		{
			$filelists[] = $fname;
		}
	}
	$bakfilesTmp = implode(',', $filelists);

    if(empty($structfile))
    {
        $structfile = '';
    }
    if(empty($startgo))
    {
        $startgo = 0;
    }


	//开始还原表结构
    if($startgo==0 && $structfile!='')
    {
        $tbdata = '';
        $fp = fopen($backup_dir_in.$structfile, 'r');
        while(!feof($fp))
        {
            $tbdata .= fgets($fp, 1024);
        }
        fclose($fp);

        $querys = explode(';', $tbdata);

        foreach($querys as $q)
        {
			if(trim($q) == '') continue;
			$db->ExecNoneQuery(trim($q).';');
        }

        $tmsg = "$tmsg<span class='blue'>完成数据表结构还原，准备还原数据...</span>";
        $doform = "<form name='gonext' method='post' action='?action=$action'>
		<input type='hidden' name='dopost' value='reset' />
		<input type='hidden' name='dirname' value='$dirname' />
        <input type='hidden' name='startgo' value='1' />
        <input type='hidden' name='tbname' value='$bakfilesTmp' /></form>
		{$dojs}";
        PutInfo($tmsg, $doform);
        exit();
    }


	//开始还原表数据
    else
    {

        $nowfile = $bakfiles[0];
        $bakfilesTmp = preg_replace("#".$nowfile."[,]{0,1}#", "", $bakfilesTmp);
        $oknum = 0;

		if(filesize($backup_dir_in.$nowfile) > 0 )
        {
            $fp = fopen($backup_dir_in.$nowfile, 'r');
            while(!feof($fp))
            {
                $line = trim(fgets($fp, 512*1024));
                if($line == '') continue;
                $rs = $db->ExecNoneQuery($line);
                $oknum++;
            }
            fclose($fp);
        }

        if($bakfilesTmp == '')
        {

			//生成全局配置文件
			$configfile = SITE_DATA.'/config.cache.php';
			$fp = fopen($configfile, 'w');
			flock($fp, 3);//锁定文件
			fwrite($fp, "<"."?php\r\n");
			
			$dosql->Execute("select `varname`,`vartype`,`varvalue`,`vargroup` from `#@__webconfig` order by orderid asc");
			while($row = $dosql->GetArray())
			{
				if($row['vartype'] == 'number')
				{
					if($row['varvalue'] == '') $row['varvalue'] = 0;
					fwrite($fp, "\${$row['varname']} = ".$row['varvalue'].";\r\n");
				}
				else
				{
					fwrite($fp, "\${$row['varname']} = '".str_replace("'",'',$row['varvalue'])."';\r\n");
				}
			}
			fwrite($fp,"?".">");
			fclose($fp);

            PutInfo("<strong class='blue'>完成所有数据还原！</strong><br /><br /><a href='?action=$action'>[如果您的浏览器没有自动跳转，请点击这里]</a>".$donejs);
			exit();
        }
        $tmsg = "$tmsg<div class='red'>成功还原{$nowfile}的{$oknum}条记录...</div>";
        $doform = "<form name='gonext' method='post' action='?action=$action'>
		<input type='hidden' name='dopost' value='reset' />
		<input type='hidden' name='dirname' value='$dirname' />
        <input type='hidden' name='startgo' value='1' />
        <input type='hidden' name='tbname' value='$bakfilesTmp' /></form>
		{$dojs}";
        PutInfo($tmsg, $doform);
        exit();
    }
}
?>