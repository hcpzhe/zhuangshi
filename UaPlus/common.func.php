<?php	if(!defined('IN_SITE')) exit("Request Error!");
/*
 * 函数说明：截取指定长度的字符串
 *         utf-8专用 汉字和大写字母长度算1，其它字符长度算0.5
 *
 * @param  string  $str  原字符串
 * @param  int     $len  截取长度
 * @param  string  $etc  省略字符...
 * @return string        截取后的字符串
 */
function ReStrLen($str, $len=10, $etc='...')
{
    $restr = '';
    $i = 0;
    $n = 0.0;

    //字符串的字节数
    $strlen = strlen($str);
    while(($n < $len) and ($i < $strlen))
    {
       $temp_str = substr($str, $i, 1);

       //得到字符串中第$i位字符的ASCII码
       $ascnum = ord($temp_str);

       //如果ASCII位高与252
       if($ascnum >= 252) 
       {
            //根据UTF-8编码规范，将6个连续的字符计为单个字符
            $restr = $restr.substr($str, $i, 6); 
            //实际Byte计为6
            $i = $i + 6; 
            //字串长度计1
            $n++; 
       }
       elseif($ascnum >= 248)
       {
            $restr = $restr.substr($str, $i, 5);
            $i = $i + 5;
            $n++;
       }
       elseif($ascnum >= 240)
       {
            $restr = $restr.substr($str, $i, 4);
            $i = $i + 4;
            $n++;
       }
       elseif($ascnum >= 224)
       {
            $restr = $restr.substr($str, $i, 3);
            $i = $i + 3 ;
            $n++;
       }
       elseif ($ascnum >= 192)
       {
            $restr = $restr.substr($str, $i, 2);
            $i = $i + 2;
            $n++;
       }

       //如果是大写字母 I除外
       elseif($ascnum>=65 and $ascnum<=90 and $ascnum!=73)
       {
            $restr = $restr.substr($str, $i, 1);
            //实际的Byte数仍计1个
            $i = $i + 1; 
            //但考虑整体美观，大写字母计成一个高位字符
            $n++; 
       }

       //%,&,@,m,w 字符按1个字符宽
       elseif(!(array_search($ascnum, array(37, 38, 64, 109 ,119)) === FALSE))
       {
            $restr = $restr.substr($str, $i, 1);
            //实际的Byte数仍计1个
            $i = $i + 1;
            //但考虑整体美观，这些字条计成一个高位字符
            $n++; 
       }

       //其他情况下，包括小写字母和半角标点符号
       else
       {
            $restr = $restr.substr($str, $i, 1);
            //实际的Byte数计1个
            $i = $i + 1; 
            //其余的小写字母和半角标点等与半个高位字符宽
            $n = $n + 0.5; 
       }
    }

    //超过长度时在尾处加上省略号
    if($i < $strlen)
    {
       $restr = $restr.$etc;
    }

    return $restr;
}


//获得当前的页面文件的url
function GetCurUrl()
{
    if(!empty($_SERVER["REQUEST_URI"]))
    {
        $nowurls = explode("?",$_SERVER["REQUEST_URI"]);
        $nowurl = $nowurls[0];
    }
    else
    {
        $nowurl = $_SERVER["PHP_SELF"];
    }

    return $nowurl;
}


//获取IP
function GetIP()
{
    static $realip = NULL;
    if($realip !== NULL)
    {
        return $realip;
    }
    if(isset($_SERVER))
    {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            /* 取X-Forwarded-For中第x个非unknown的有效IP字符? */
            foreach($arr as $ip)
            {
                $ip = trim($ip);
                if ($ip != 'unknown')
                {
                    $realip = $ip;
                    break;
                }
            }
        }
        elseif(isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if(isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '127.0.0.1';
            }
        }
    }
    else
    {
        if(getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        else if(getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = ! empty($onlineip[0]) ? $onlineip[0] : '127.0.0.1';
    return $realip;
}


//查看数据大小
function GetRealSize($size)
{
    $kb = 1024;          // Kilobyte
    $mb = 1024 * $kb;    // Megabyte
    $gb = 1024 * $mb;    // Gigabyte
    $tb = 1024 * $gb;    // Terabyte

    if($size < $kb)
    {
        return round($size,2).'B';
    }
    else if($size < $mb)
    {
        return round($size/$kb,2).'KB';
    }
    else if($size < $gb)
    {
        return round($size/$mb,2).'MB';
    }
    else if($size < $tb)
    {
        return round($size/$gb,2).'GB';
    }
    else
    {
        return round($size/$tb,2).'TB';
    }
}


//获取文件夹大小
function GetDirSize($dir)
{
    $handle = opendir($dir);
    $sizeResult = '';
    $FolderOrFile = readdir($handle);

    while($FolderOrFile !== false)
    {
        if($FolderOrFile != '.' && $FolderOrFile != '..')
        {
            if(is_dir("$dir/$FolderOrFile"))
            {
                $sizeResult += GetDirSize("$dir/$FolderOrFile");
            }
            else
            {
                $sizeResult += filesize("$dir/$FolderOrFile");
            }
        }
    }

    closedir($handle);
    if(empty($sizeResult)) $sizeResult = 0;

    return $sizeResult;
}

//获取文件夹大小(upall专用)
function GetFolderSize($directory = './'){
   $directorySize = 0;
   if ($dh = @opendir($directory)){
      while (($fileName = readdir ($dh))){
         if ($fileName != "." && $fileName != ".."){
            if (is_file($directory . "/" . $fileName))
               $directorySize += filesize($directory . "/" . $fileName);
            if (is_dir($directory . "/" . $fileName))
               $directorySize += GetFolderSize($directory . "/" . $fileName);
         }
      }
   }
   @closedir($dh);
   return $directorySize;
}

// 数据库使用量
function GetMysqlSize(){
    global $dosql,$GLOBALS;
    $dbName = $GLOBALS['db_name'];
    $sql = "SELECT table_schema AS db, " .
        "sum( data_length + index_length ) /1024 / 1024 AS total " .
        "FROM information_schema.TABLES " .
        "WHERE table_schema = '$dbName' " .
        "GROUP BY table_schema " .
        "LIMIT 1";
    $mysqlUseRs = $dosql->GetOne($sql);
    return $mysqlUseRs['total'];
}

//返回格林威治标准时间
function MyDate($format='Y-m-d H:i:s', $timest=0)
{
    global $cfg_timezone;
    $addtime = $cfg_timezone * 3600;
    if(empty($format))
    {
        $format = 'Y-m-d H:i:s';
    }
    return gmdate($format, $timest+$addtime);
}


//返回格式化(Y-m-d H:i:s)的时间
function GetDateTime($mktime)
{
    return MyDate('Y-m-d H:i:s',$mktime);
}


//返回格式化(Y-m-d)的日期
function GetDateMk($mktime)
{
    return MyDate('Y-m-d', $mktime);
}


//从普通时间转换为Linux时间截
function GetMkTime($dtime)
{
    if(!preg_match("/[^0-9]/", $dtime))
    {
        return $dtime;
    }
    $dtime = trim($dtime);
    $dt = array(1970, 1, 1, 0, 0, 0);
    $dtime = preg_replace("/[\r\n\t]|日|秒/", " ", $dtime);
    $dtime = str_replace("年", "-", $dtime);
    $dtime = str_replace("月", "-", $dtime);
    $dtime = str_replace("时", ":", $dtime);
    $dtime = str_replace("分", ":", $dtime);
    $dtime = trim(preg_replace("/[ ]{1,}/", " ", $dtime));
    $ds = explode(" ", $dtime);
    $ymd = explode("-", $ds[0]);
    if(!isset($ymd[1])) $ymd = explode(".", $ds[0]);
    if(isset($ymd[0])) $dt[0] = $ymd[0];
    if(isset($ymd[1])) $dt[1] = $ymd[1];
    if(isset($ymd[2])) $dt[2] = $ymd[2];
    if(strlen($dt[0])==2) $dt[0] = '20'.$dt[0];
    if(isset($ds[1]))
    {
        $hms = explode(":", $ds[1]);
        if(isset($hms[0])) $dt[3] = $hms[0];
        if(isset($hms[1])) $dt[4] = $hms[1];
        if(isset($hms[2])) $dt[5] = $hms[2];
    }
    foreach($dt as $k=>$v)
    {
        $v = preg_replace("/^0{1,}/", '', trim($v));
        if($v == '')
        {
            $dt[$k] = 0;
        }
    }
    
    $mt = mktime($dt[3], $dt[4], $dt[5], $dt[1], $dt[2], $dt[0]);
    if(!empty($mt)) return $mt;
    else return time();
}


//显示信息
function ShowMsg($msg='', $gourl='-1')
{
    if($gourl != '-1')
    {
        echo '<script>alert("'.$msg.'");location.href="'.$gourl.'";</script>';
    }
    else
    {
        echo '<script>alert("'.$msg.'");history.go(-1);</script>';
    }
}


//读取文件内容
function Readf($file)
{
    if(file_exists($file) && is_readable($file))
    {
        if(function_exists('file_get_contents'))
        {
            $str = file_get_contents($file);
        }
        else
        {
            $str = '';

            $fp = fopen($file, 'r');
            while(!feof($fp))
            {
                $getstr .= fgets($fp, 1024);
            }
            fclose($fp);
        }
        return $str;
    }
    else
    {
        return FALSE;
    }
}


//写入文件内容
function Writef($file,$str,$mode='w')
{
    if(file_exists($file) && is_writable($file))
    {
        if(function_exists('file_put_contents'))
        {
            file_put_contents($file, $str);
        }
        else
        {
            $fp = fopen($file, $mode);
            flock($fp, 3);
            fwrite($fp, $str);
            fclose($fp);
        }
    
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}


//查看url中是否包含http
function IsHttpUrl($url)
{
    if(!preg_match("/^(http|ftp):/", $url))
    {
        $url = 'http://'.$url;
    }

    return $url;
}


//执行时间函数
function ExecTime()
{
    $time = explode(" ", microtime());
    $usec = (double)$time[0];
    $sec = (double)$time[1];
    return $sec + $usec;
}


//清除HTML
function ClearHtml($str)
{
    $str = strip_tags($str);

    //首先去掉头尾空格
    $str = trim($str);

    //接着去掉两个空格以上的
    $str = preg_replace('/\s(?=\s)/', '', $str);

    //最后将非空格替换为一个空格
    $str = preg_replace('/[\n\r\t]/', ' ', $str);

    return $str;
}


//引用函数
function Inc($file)
{
    require_once($file);
}

/**
 * 在线翻译函数
 * 查询步骤：1、查询过的缓存数据；2、在线查谷歌
 * $language：
 *		中英：zh-CN|en
 *		中日：zh-CN|ja
 */
function translate($text = '', $language = 'zh-CN|en'){
    if ($language == '1' || $language == '-1') return $text; // 这行是多余的，可以删除，写上这行只是为了偷懒
    if ($language == '2') $language = 'zh-CN|en'; // 这行是多余的，可以删除，写上这行只是为了偷懒
    if ($language == '3') $language = 'zh-CN|ja'; // 这行是多余的，可以删除，写上这行只是为了偷懒
    if ($language == '4') $language = 'zh-CN|ko'; // 这行是多余的，可以删除，写上这行只是为了偷懒
    $text = trim($text);
    if (empty($text)) return '';
    $outText = ''; // 最后输出的、翻译好的文字
    $dictFile = str_replace('|','2',$language);
    $dictFile = str_replace('/','2',$dictFile);
    $dictFile = str_replace('\\','2',$dictFile);
	 $dictFile = SITE_DATA . '/lang/'.$dictFile.'.dict'; // 存放翻译结果的字典文件
	 
    // 读缓存的字典文件，若无再查Google。
    if (empty($outText)){
        if (!file_exists($dictFile)) @file_put_contents($dictFile,'');
        if (!is_writable($dictFile)) return 'UnRead';
        $dictData = file_get_contents($dictFile);
        $dict = (array)json_decode($dictData);
        foreach ($dict as $i => $v){
            if ($text == $i) $outText = $v;
        }
    }
    
    // 查Google
    if (empty($outText)){
        @set_time_limit(0);
        $html = "";
        $ch = curl_init("http://google.com/translate_t?langpair=" . urlencode($language) . "&text=" . urlencode($text));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $html = curl_exec($ch);
        if (curl_errno($ch))$html = "";
        curl_close($ch);
        if (!empty($html)){
            $x = explode("</span></span></div></div>", $html);
            $x = explode("onmouseout=\"this.style.backgroundColor='#fff'\">", $x[0]);
            // 写入字典
            $dict[$text] = $x[1];
            file_put_contents($dictFile, json_encode($dict));
            $outText = $x[1];
        }
    }
    
    // 输出结果
    if (!empty($outText)){
        return $outText;
    }else{
        return '';
    }
}
function t($text = '', $language = 'zh-CN|en'){
	 return translate($text, $language);
}
?>
