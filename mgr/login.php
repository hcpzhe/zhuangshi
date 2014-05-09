<?php
//检测网站是否已安装
$signFile = dirname(__FILE__).'/../data/install_lock.txt';
if (!file_exists($signFile)) header('location: ../install/');
$dn = basename(dirname(dirname(__FILE__)));
require_once(dirname(__FILE__).'/../UaPlus/common.inc.php');

//验证码获取函数
function GetCkVdValue()
{
	@session_start();
	return isset($_SESSION['ckstr']) ? $_SESSION['ckstr'] : '';
}


//验证码重置函数
function ResetVdValue()
{
	@session_start();
	$_SESSION['ckstr'] = '';
	$_SESSION['ckstr_last'] = '';
}


//判断登陆请求
if(@$dopost == 'login')
{
	
	//删除已过时记录
	$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE (UNIX_TIMESTAMP(NOW())-time)/60>15");


	//判断是否被暂时禁止登录
	$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE username='$username'");
	if(!empty($r))
	{
		$min = round((time()-$r['time']))/60;
		if($r['num']==0 and $min<=15)
		{
			ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','login.php');
			exit();
		}
	}


	//检测验证码
	$validate = empty($validate) ? '' : strtolower($validate);
	$svali = strtolower(GetCkVdValue());

	if($validate == '' || $validate != $svali)
	{
		ResetVdValue();
		ShowMsg('验证码不正确！','login.php');
		exit();
	}
	else
	{

		$password = md5(md5($password));
		$row = $dosql->GetOne("SELECT * FROM `#@__admin` WHERE username='$username'");

		if(!is_array($row) or $password!=$row['password'])
		{
			$logintime = time();
			$loginip   = GetIP();

			$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE username='$username'");
			if(!empty($r))
			{
				$num = $r['num']-1;

				if($num == 0)
				{
					$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET time=$logintime, num=$num WHERE username='$username'");
					ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','login.php');
					exit();
				}
				else if($r['num']<=5 and $r['num']>0)
				{
					$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET time=$logintime, num=$num WHERE username='$username'");
					ShowMsg('用户名或密码不正确！您还有'.$num.'次尝试的机会！','login.php');
					exit();
				}
			}
			else
			{
				$dosql->ExecNoneQuery("INSERT INTO `#@__failedlogin` (username, ip, time, num, isadmin) VALUES ('$username', '$loginip', '$logintime', 5, 1)");
				ShowMsg('用户名或密码不正确！您还有5次尝试的机会！','login.php');
				exit();
			}
		}


		//密码正确，查看是否被禁止登录
		else if($row['checkadmin'] == 'false')
		{
			ShowMsg('抱歉，您的账号被禁止登陆！','login.php');
			exit();
		}


		//用户名密码正确
		else
		{
			$logintime = time();
			$loginip = GetIP();


			//删除禁止登录
			if(!empty($r))
			{
				$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE username='$username'");
			}


			//提取当前用户账号
			$_SESSION['admin'] = $username;
			//提取当前用户权限
			$_SESSION['adminlevel'] = $row['levelname'];
			//提取上次登录时间
			$_SESSION['lastlogintime'] = $row['logintime'];
			//提取上次登录IP
			$_SESSION['lastloginip'] = $row['loginip'];
			//记录本次登录时间
			$_SESSION['logintime'] = $logintime;

			$dosql->ExecNoneQuery("update `#@__admin` set loginip='$loginip',logintime='$logintime' where username='$username'");
			header('location:default.php?gourl=35698a3150c6403fa3571d1878e87c6e');
			exit();
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname;?> _ 后台管理系统</title>
<link href="templets/style/admin.css" rel="stylesheet" />
<script src="templets/js/jquery.min.js"></script>
<script>
function CheckForm()
{
	if($("#username").val() == "")
	{
		alert("请输入用户名！");
		$("#username").focus();
		return false;
	}
	if($("#password").val() == "")
	{
		alert("请输入密码！");
		$("#password").focus();
		return false;
	}
	if($("#validate").val() == "")
	{
        alert("请输入验证码！");
        $("#validate").focus();
        return false;
    }
}

$(function(){
	$("#username").focus(function(){
		$("#username").attr("class", "login_area_input_on"); 
	}).blur(function(){
		$("#username").attr("class", "login_area_input"); 
	});

	$("#password").focus(function(){
		$("#password").attr("class", "login_area_input_on mar8"); 
	}).blur(function(){
		$("#password").attr("class", "login_area_input mar8"); 
	});

	$("#validate").focus(function(){
		$("#validate").attr("class", "login_area_ckstr_on"); 
	}).blur(function(){
		$("#validate").attr("class", "login_area_ckstr"); 
	});

	$("#username").focus();
});
</script>
</head>
<body class="login_body">
<div class="login_text"><span class="login_note">
	<?php if(strstr(GetCurUrl(), '/admin/login')) echo '提示：您的后台路径为/<i>admin</i>/，建议更改为更加安全的路径！'; ?>
	</span>
	</div>
<div class="login_warp">
	<div class="login_logo"><a href="../" title="点击返回网站首页"></a></div>
	<div class="login_area">
		<form name="login" method="post" action="" onSubmit="return CheckForm()">
			<label>帐　号：<input type="text" name="username" id="username" class="login_area_input" maxlength="20" /></label>
			<label>密　码：<input type="password" name="password" id="password" class="login_area_input mar8" maxlength="16" /></label>
			<div class="check_str">
				验证码：<input type="text" name="validate" class="login_area_ckstr" id="validate" maxlength="4" />
				<span><img id="ckstr" name="ckstr" src="../data/captcha/ckstr.php" title="看不清？点击更换" align="absmiddle" style="cursor:pointer;" onClick="this.src=this.src+'?'" /> <a href="javascript:;" onClick="var v=document.getElementById('ckstr');v.src=v.src+'?';return false;">看不清?</a></span></div>
			<div class="hr_20"></div>
			<input type="submit" class="login_area_btn" value="" style="cursor:pointer;" />
			<input type="hidden" name="dopost" value="login" />
		</form>
	</div>
</div>
<div class="login_copyright"><?php echo $cfg_copyright;?></div>
</body>
</html>