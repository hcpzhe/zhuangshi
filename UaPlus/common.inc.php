<?php	if(!isset($dn)) exit("Request Error [no domain name]!");?>
<?php
header("Content-Type:text/html;charset=utf-8");
define('SITE_INC', preg_replace("/[\/\\\\]{1,}/", '/', dirname(__FILE__)));
define('SITE_ROOT', preg_replace("/[\/\\\\]{1,}/", '/', SITE_INC."/../"));
//define('SITE_ROOT', preg_replace("/[\/\\\\]{1,}/", '/', substr(SITE_INC."/".$dn, 0, -8)));
define('SITE_DATA', SITE_ROOT.'/data');
define('SITE_UPLOAD', SITE_ROOT.'/uploads');
define('SITE_BACKUP', SITE_DATA.'/backup');
define('IN_SITE', TRUE); //发放登入牌
//echo SITE_INC . '<br>';
//echo SITE_ROOT . '<br>';
//echo SITE_DATA . '<br>';
//echo $dn;
//检查外部传递的值并转义
function _RunMagicQuotes(&$svar)
{
    if(!get_magic_quotes_gpc())
    {
        if(is_array($svar))
        {
            foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
        }
        else
        {
            if(strlen($svar)>0 && preg_match('#^(cfg_|GLOBALS|_GET|_POST|_COOKIE)#',$svar) )
            {
              exit('不允许请求的变量!');
            }

            $svar = addslashes($svar);
        }
    }
    return $svar;
}


//直接应用变量名称替代
foreach(array('_GET','_POST','_COOKIE') as $_request)
{
	foreach($$_request as $_k => $_v) ${$_k} = _RunMagicQuotes($_v);
}


//Session保存路径
$sess_savepath = SITE_DATA.'/sessions/';
if(is_writable($sess_savepath) && is_readable($sess_savepath))
{
	session_save_path($sess_savepath);
}


//上传文件保存路径
$cfg_image_dir = SITE_UPLOAD.'/image';
$cfg_soft_dir  = SITE_UPLOAD.'/soft';
$cfg_media_dir = SITE_UPLOAD.'/media';


//系统版本号
$cfg_version = file_get_contents(SITE_DATA.'/update/version.txt');


//全局配置文件
require_once(SITE_DATA.'/config.cache.php');


//全局常用函数
require_once(SITE_INC.'/common.func.php');


//引入数据库配置
require_once(SITE_DATA.'/conn.inc.php');


//引入数据库类
if($cfg_mysql_type == 'mysqli' and function_exists('mysqli_init'))
{
    require_once(SITE_INC.'/mysqli.class.php');
}
else
{
    require_once(SITE_INC.'/mysql.class.php');
}


//判断是否开启错误提示
if($cfg_diserror == 'N')
{
	error_reporting(0);
}


//由于这个函数对于是php5.1以下版本并无意义
//因此实际上的时间调用，应该用MyDate函数调用
if(PHP_VERSION > '5.1')
{
	$time51 = $cfg_timezone * -1;
    @date_default_timezone_set('Etc/GMT'.$time51);
}

?>