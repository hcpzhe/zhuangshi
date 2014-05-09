<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

//初始化参数
$tbname = '#@__member';
$gourl  = 'member.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加会员
if($action == 'add')
{
	if(preg_match("/[^0-9a-zA-Z_@!\.-]/",$username) || preg_match("/[^0-9a-zA-Z_@!\.-]/",$password))
	{
		ShowMsg('用户名或密码非法！请使用[0-9a-zA-Z_@!.-]内的字符！','-1');
		exit();
	}
	if($password != $repassword)
	{
		ShowMsg('两次输入的密码不一样！','-1');
		exit();
	}
	
	$r = $dosql->GetOne("SELECT username FROM `$tbname` WHERE username='$username'");
	if(!empty($r['username']))
	{
		ShowMsg('用户名已存在！','-1');
		exit();
	}

	$password  = md5(md5($password));
	$birthdate = $birthyear.'-'.$birthmonth.'-'.$birthday;
	$regtime   = GetMkTime($regtime);

	$sql = "INSERT INTO `$tbname` (username, password, truename, sex, birthdate, province, city, address, telephone, zipcode, cardtype, cardnum, showinfo, picurl, level, integral, regtime, regip, checkinfo) VALUES ('$username', '$password', '$truename', '$sex', '$birthdate', '$province', '$city', '$address', '$telephone', '$zipcode', '$cardtype', '$cardnum', '$showinfo', '$picurl', '$level', '$integral', '$regtime', '$regip', '$checkinfo')";	
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改会员信息
else if($action == 'update')
{
	if(preg_match("/[^0-9a-zA-Z_@!\.-]/",$username) || preg_match("/[^0-9a-zA-Z_@!\.-]/",$password))
	{
		ShowMsg('用户名或密码非法！请使用[0-9a-zA-Z_@!.-]内的字符！','-1');
		exit();
	}
	if($password != $repassword)
	{
		ShowMsg('两次输入的密码不一样！','-1');
		exit();
	}

	$birthdate = $birthyear.'-'.$birthmonth.'-'.$birthday;
	$regtime   = GetMkTime($regtime);

	if($password == '')
	{
		$sql = "UPDATE `$tbname` SET truename='$truename', sex='$sex', birthdate='$birthdate', province='$province', city='$city', address='$address', telephone='$telephone', zipcode='$zipcode', cardtype='$cardtype', cardnum='$cardnum', showinfo='$showinfo', picurl='$picurl', level='$level', integral='$integral', checkinfo='$checkinfo' WHERE id=$id";
	}
	else
	{
		$password = md5(md5($password));
		$sql = "UPDATE `$tbname` SET password='$password', truename='$truename', sex='$sex', birthdate='$birthdate', province='$province', city='$city', address='$address', telephone='$telephone', zipcode='$zipcode', cardtype='$cardtype', cardnum='$cardnum', showinfo='$showinfo', picurl='$picurl', level='$level', integral='$integral', checkinfo='$checkinfo' WHERE id=$id";
	}

	if($dosql->ExecNoneQuery($sql))
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