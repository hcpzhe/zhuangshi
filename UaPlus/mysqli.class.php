<?php   if(!defined('IN_SITE')) exit("Request Error!");

/**
 * 数据库类
 * 说明:系统底层数据库核心类
 *      调用这个类前,请先设定这些外部变量
 *      $GLOBALS['db_host'];
 *      $GLOBALS['db_user'];
 *      $GLOBALS['db_pwd'];
 *      $GLOBALS['db_name'];
 *      $GLOBALS['db_tablepre'];
 */

// 在系统所有文件中均不需要单独初始化这个类
// 可直接用 $dosql dosqli 或 $db 进行操作
// 为了防止错误，操作完后不必关闭数据库

@set_time_limit(0);
$dosql = $dosqli = $db = new MySql(false);

class MySql
{	

    var $db_host;
    var $db_user;
    var $db_pwd;
    var $db_name;
    var $db_tablepre;

	var $linkid;
    var $result;
    var $querystring;
    var $isclose;
	var $safecheck;


    //用外部定义的变量初始类，并连接数据库
    function __construct($pconnect=false,$nconnect=true)
    {
        $this->isclose = false;
        $this->safecheck = true;
        if($nconnect)
        {
            $this->Init($pconnect);
        }
    }

    function MySql($pconnect=false,$nconnect=true)
    {
        $this->__construct($pconnect,$nconnect);
    }

    function Init($pconnect=false)
    {
		$this->db_host      = $GLOBALS['db_host'];
        $this->db_user      = $GLOBALS['db_user'];
        $this->db_pwd       = $GLOBALS['db_pwd'];
        $this->db_name      = $GLOBALS['db_name'];
        $this->db_tablepre  = $GLOBALS['db_tablepre'];
        $this->linkid       = 0;
		$this->result['me'] = 0;
        $this->querystring  = '';
        $this->Open($pconnect);
    }


    //连接数据库
    function Open($pconnect=false)
    {
        global $dsqli;

        //连接数据库
        if($dsqli && !$dsqli->isclose)
        {
            $this->linkid = $dsqli->linkid;
        }
        else
        {
            $i = 0;
            @list($dbhost, $dbport) = explode(':', $this->db_host);
            !$dbport && $dbport = 3306;

            $this->linkid = mysqli_init();
            @mysqli_real_connect($this->linkid, $dbhost, $this->db_user, $this->db_pwd, false, $dbport);
            @mysqli_errno($this->linkid) != 0 && $this->DisplayError("错误警告：连接数据库失败，可能数据库密码不对或数据库服务器出错！");

            //复制一个对象副本
            CopySQLiPoint($this);
        }

        //处理错误，成功连接则选择数据库
        if(!$this->linkid)
        {
            $this->DisplayError("错误警告：连接数据库失败，可能数据库密码不对或数据库服务器出错！");
            exit();
        }

        $serverinfo = @mysqli_get_server_info($this->linkid);

        if ($serverinfo > '4.1' && $GLOBALS['db_charset']) 
        {
            mysqli_query($this->linkid, "SET character_set_connection=" . $GLOBALS['db_charset'] . ",character_set_results=" . $GLOBALS['db_charset'] . ",character_set_client=binary");
        }

        if ($serverinfo > '5.0')
		{
            mysqli_query($this->linkid, "SET sql_mode=''");
        }

        if ($this->db_name && !@mysqli_select_db($this->linkid, $this->db_name))
		{
            $this->DisplayError('无法使用数据库');
			exit();
        }

        return true;
    }


    //获得错误描述
    function GetError()
    {
        $str = mysql_error();
        return $str;
    }

    //关闭数据库
    //mysql能自动管理非持久连接的连接池
    //实际上关闭并无意义并且容易出错，所以取消这函数
    function Close($isok=false)
    {
        $this->FreeResultAll();
        if($isok)
        {
            @mysqli_close($this->linkid);
            $this->isclose = true;
            $GLOBALS['dsql'] = null;
        }
    }

    //定期清理死连接
    function ClearErrLink()
    {
    }

    //关闭指定的数据库连接
    function CloseLink($dblink)
    {
        @mysqli_close($dblink);
    }
    
    function Esc( $_str ) 
    {
        if ( version_compare( phpversion(), '4.3.0', '>=' ) ) 
        {
            return @mysqli_real_escape_string($this->linkid, $_str );
        } else {
            return @mysqli_escape_string ($this->linkid, $_str );
        }
    }


	 //执行一个不返回结果的SQL语句，如update,delete,insert等
    function ExecNoneQuery($sql='')
    {
        global $dsqli;

        if($dsqli->isclose)
        {
            $this->Open(false);
            $dsqli->isclose = false;
        }

        if(!empty($sql))
        {
            $this->SetQuery($sql);
        }
		else
		{
            return false;
        }

        //SQL语句安全检查
        if($this->safecheck) $this->CheckSql($this->querystring,'update');
        return mysqli_query($this->linkid, $this->querystring);
    }
	

    //执行一个带返回结果的SQL语句，如SELECT，SHOW等
    function Execute($sql='', $id="me")
    {
        global $dsqli;
        if($dsqli->isclose)
        {
            $this->Open(false);
            $dsqli->isclose = false;
        }
        if(!empty($sql))
        {
            $this->SetQuery($sql);
        }

        //SQL语句安全检查
        if($this->safecheck)
        {
            $this->CheckSql($this->querystring);
        }
    

        $this->result[$id] = mysqli_query($this->linkid, $this->querystring);


		//查询性能测试
		//$t1 = ExecTime();
        //$queryTime = ExecTime() - $t1;
        //if($queryTime > 0.05) {
            //echo $this->querystring."--{$queryTime}<hr />\r\n"; 
        //}
        
        if($this->result[$id]===false)
        {
            $this->DisplayError(mysqli_error($this->linkid)." <br />Error sql: <font color='red'>".$this->querystring."</font>");
        }
    }


    //执行一个不与任何表名有关的SQL语句,Create等
    function ExecuteSafeQuery($sql,$id="me")
    {
        global $dsqli;
        if($dsqli->isclose)
        {
            $this->Open(false);
            $dsqli->isclose = false;
        }
        $this->result[$id] = @mysqli_query($sql,$this->linkid);
    }


	//执行一个SQL语句,返回前一条记录或仅返回一条记录
    function GetOne($sql='',$acctype=MYSQLI_ASSOC)
    {
        global $dsqli;
        if($dsqli->isclose)
        {
            $this->Open(false);
            $dsqli->isclose = false;
        }
        if(!empty($sql))
        {
            if(!preg_match("/LIMIT/i",$sql)) $this->SetQuery(preg_replace("/[,;]$/i", '', trim($sql))." LIMIT 0,1;");
            else $this->SetQuery($sql);
        }
        $this->Execute($sql,"one");
        $arr = $this->GetArray("one", $acctype);
        if(!is_array($arr))
        {
            return '';
        }
        else
        {
            @mysqli_free_result($this->result["one"]); return($arr);
        }
    }


    //返回当前的一条记录并把游标移向下一记录
    // MYSQLI_ASSOC、MYSQLI_NUM、MYSQLI_BOTH
    function GetArray($id="me",$acctype=MYSQLI_ASSOC)
    {
        if($this->result[$id]===0)
        {
            return false;
        }
        else
        {
            return @mysqli_fetch_array($this->result[$id], $acctype);
        }
    }

    function GetObject($id="me")
    {
        if($this->result[$id]===0)
        {
            return false;
        }
        else
        {
            return mysqli_fetch_object($this->result[$id]);
        }
    }

    // 检测是否存在某数据表
    function IsTable($tbname)
    {
        $prefix="#@__";
        $tbname = str_replace($prefix, $this->db_tablepre, $tbname);
        if( mysqli_num_rows( @mysqli_query($this->linkid, "SHOW TABLES LIKE '".$tbname."'")))
        {
            return true;
        }
        return false;
    }

    //获得MySql的版本号
    function GetVersion($isformat=true)
    {
        global $dsqli;
        if($dsqli->isclose)
        {
            $this->Open(false);
            $dsqli->isclose = false;
        }
        $rs = mysqli_query($this->linkid, "SELECT VERSION();");
        $row = mysqli_fetch_array($rs);
        $mysql_version = $row[0];
        mysqli_free_result($rs);
        if($isformat)
        {
            $mysql_versions = explode(".",trim($mysql_version));
            $mysql_version = number_format($mysql_versions[0].".".$mysql_versions[1],2);
        }
        return $mysql_version;
    }

    //获取特定表的信息
    function GetTableFields($tbname, $id="me")
    {
        $prefix="#@__";
        $tbname = str_replace($prefix, $this->db_tablepre, $tbname);
        $query = "SELECT * FROM {$tbname} LIMIT 0,1";
        $this->result[$id] = mysqli_query($this->linkid, $query);
    }

    //获取字段详细信息
    function GetFieldObject($id="me")
    {
        return mysqli_fetch_field($this->result[$id]);
    }

    //获得查询的总记录数
    function GetTotalRow($id="me")
    {
        if($this->result[$id]===0)
        {
            return -1;
        }
        else
        {
            return @mysqli_num_rows($this->result[$id]);
        }
    }
	
	//获得指定表数据总记录数
	function GetTableRow($tbname='',$field="id")
	{
		if($tbname == '') return false;
		$this->Execute("SELECT $field FROM `$tbname`");
		return $this->GetTotalRow();
	}

    //获取上一步INSERT操作产生的ID
    function GetLastID()
    {
        //如果 AUTO_INCREMENT 的列的类型是 BIGINT，则 mysqli_insert_id() 返回的值将不正确。
        //可以在 SQL 查询中用 MySQL 内部的 SQL 函数 LAST_INSERT_ID() 来替代。
        //$rs = mysqli_query($this->linkid, "Select LAST_INSERT_ID() as lid");
        //$row = mysqli_fetch_array($rs);
        //return $row["lid"];
        return mysqli_insert_id($this->linkid);
    }

    //释放记录集占用的资源
    function FreeResult($id="me")
    {
        @mysqli_free_result($this->result[$id]);
    }

    function FreeResultAll()
    {
        if(!is_array($this->result))
        {
            return '';
        }
        foreach($this->result as $kk => $vv)
        {
            if($vv)
            {
                @mysqli_free_result($vv);
            }
        }
    }

    //设置SQL语句，会自动把SQL语句里的#@__替换为$this->db_tablepre(在配置文件中为$cfg_dbprefix)
    function SetQuery($sql)
    {
        $prefix="#@__";
        $sql = str_replace($prefix,$this->db_tablepre,$sql);
        $this->querystring = $sql;
    }

    function SetSql($sql)
    {
        $this->SetQuery($sql);
    }

    //显示数据链接错误信息
    function DisplayError($msg)
    {
        $emsg = '';
        $emsg .= '<div><h3 style="color:red;line-height:30px;">请检查执行语句是否正确或录入内容是否正确!</h3>';
        $emsg .= '<strong>错误文件</strong>：'.GetCurUrl().'<br />';
        $emsg .= '<strong>错误信息</strong>：'.$msg.'';
        $emsg .= '</div>';

        echo $emsg;

        //保存MySql错误日志
		$savemsg = 'Page: '.GetCurUrl()."\r\nError: ".$msg;
        $fp = @fopen(dirname(__FILE__).'/../data/error/mysql_error_trace.txt', 'a');
		@fwrite($fp, "{$savemsg}\r\n\r\n\r\n");
        @fclose($fp);
    }


	//SQL语句过滤程序，由80sec提供，这里作了适当的修改
    function CheckSql($db_string, $querytype='select')
    {
        $clean = '';
        $error = '';
        $old_pos = 0;
        $pos = -1;
        $log_file = dirname(__FILE__).'/../data/error/mysql_safe_trace.txt';


        //如果是普通查询语句，直接过滤一些特殊语法
        if($querytype == 'select')
        {
            $notallow1 = "[^0-9a-z@\._-]{1,}(union|sleep|benchmark|load_file|outfile)[^0-9a-z@\.-]{1,}";

            if(preg_match("/".$notallow1."/", $db_string))
            {
				$userIP = GetIP();
        		$getUrl = GetCurUrl();

                fputs(fopen($log_file,'a+'),"$userIP||$getUrl||$db_string||SelectBreak\r\n");
                exit('<div><h3 style="color:red;line-height:30px;">安全警告: 请检查您的SQL语句是否合法!</h3>您的操作将被强制停止!</div>');
            }
        }

        //完整的SQL检查
        while(true)
        {
            $pos = strpos($db_string, '\'', $pos + 1);
            if ($pos === false)
            {
                break;
            }
            $clean .= substr($db_string, $old_pos, $pos - $old_pos);
            while (true)
            {
                $pos1 = strpos($db_string, '\'', $pos + 1);
                $pos2 = strpos($db_string, '\\', $pos + 1);
                if ($pos1 === false)
                {
                    break;
                }
                elseif ($pos2 == false || $pos2 > $pos1)
                {
                    $pos = $pos1;
                    break;
                }
                $pos = $pos2 + 1;
            }
            $clean .= '$s$';
            $old_pos = $pos + 1;
        }
        $clean .= substr($db_string, $old_pos);
        $clean = trim(strtolower(preg_replace(array('~\s+~s' ), array(' '), $clean)));

        //老版本的Mysql并不支持union，常用的程序里也不使用union，但是一些黑客使用它，所以检查它
        if (strpos($clean, 'union') !== false && preg_match('~(^|[^a-z])union($|[^[a-z])~s', $clean) != 0)
        {
            $fail  = true;
            $error = 'union detect';
        }

        //发布版本的程序可能比较少包括--,#这样的注释，但是黑客经常使用它们
        elseif (strpos($clean, '/*') > 2 || strpos($clean, '--') !== false || strpos($clean, '#') !== false)
        {
            $fail  = true;
            $error = 'comment detect';
        }

        //这些函数不会被使用，但是黑客会用它来操作文件，down掉数据库
        elseif (strpos($clean, 'sleep') !== false && preg_match('~(^|[^a-z])sleep($|[^[a-z])~s', $clean) != 0)
        {
            $fail  = true;
            $error = 'slown down detect';
        }
        elseif (strpos($clean, 'benchmark') !== false && preg_match('~(^|[^a-z])benchmark($|[^[a-z])~s', $clean) != 0)
        {
            $fail  = true;
            $error = 'slown down detect';
        }
        elseif (strpos($clean, 'load_file') !== false && preg_match('~(^|[^a-z])load_file($|[^[a-z])~s', $clean) != 0)
        {
            $fail  = true;
            $error = 'file fun detect';
        }
        elseif (strpos($clean, 'into outfile') !== false && preg_match('~(^|[^a-z])into\s+outfile($|[^[a-z])~s', $clean) != 0)
        {
            $fail  = true;
            $error = 'file fun detect';
        }

        //老版本的MYSQL不支持子查询，我们的程序里可能也用得少，但是黑客可以使用它来查询数据库敏感信息
        elseif (preg_match('~\([^)]*?select~s', $clean) != 0)
        {
            $fail  = true;
            $error = 'sub select detect';
        }
        if (!empty($fail))
        {
			$userIP = GetIP();
        	$getUrl = GetCurUrl();

            fputs(fopen($log_file,'a+'),"$userIP||$getUrl||$db_string||$error\r\n");
			exit('<div><h3 style="color:red;line-height:30px;">安全警告: 请检查您的SQL语句是否合法!</h3>您的操作将被强制停止!</div>');
        }
        else
        {
            return $db_string;
        }
    }
}

//复制一个对象副本
function CopySQLiPoint(&$ndsql)
{
    $GLOBALS['dsqli'] = $ndsql;
}
?>