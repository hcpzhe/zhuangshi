<?php require_once(dirname(__FILE__).'/config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php echo GetHeader($cid); ?>
<!-- base href="http://www.czdder.com/" -->
<script src="php/loadtrace.php" async="" type="text/javascript"></script>
<script src="js/b.js" async="" charset="utf-8" type="text/javascript"></script>
<script src="js/b.js" async="" charset="utf-8" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/minify.js"></script>
<script src="js/logger.js"></script>
<link type="text/css" rel="stylesheet" href="css/bdsstyle.css">
<link href="css/m-front-icon.css" type="text/css" rel="stylesheet">
<script charset="UTF-8" src="js/Enter.js" id="BDBridgeSendData" language="javascript" type="text/javascript"></script>
<link href="css/m-front-mess.css" type="text/css" rel="stylesheet">
<link href="css/m-front-invite.css" type="text/css" rel="stylesheet">
<script charset="UTF-8" src="js/Refresh.js" id="BDBridgeReport" language="javascript" type="text/javascript"></script>
</head>
<body>
<?php include('head.php');?>
<div class="ad"> <a href="single_article.php?cid=34" class="pr fl service_tel"></a>
  <div class="pr fr service_cont"> <a class="pr fl service_bnt s_bnt1" rel="nofollow" href="message.php"></a> <a class="pr fl service_bnt s_bnt2" rel="nofollow" href="message.php"></a> <a class="pr fl service_bnt s_bnt3" rel="nofollow" href="message.php"></a> <a class="pr fl service_bnt s_bnt4" rel="nofollow" href="message.php"></a>
    <div class="pr fl service_links"> <a class="pa service_wb" style="height:120px;" rel="nofollow" target="_blank" href="#"></a> <a class="pa service_email" style="height:120px;" rel="nofollow" href="#"></a> </div>
  </div>
</div>
<div class="Column Leader"> <em>当前位置</em> <a href="index.php">首页</a> - <a><?php echo GetCateInfo($cid);?></a> </div>
<div class="Column" style="width:960px;">
  <div class="Column-R">
    <div class="main_r_nav">
      <p><?php echo GetCateInfo($cid);?></p>
    </div>
    <div class="main_r_con">
      <dd> <?php echo Info($cid); ?></dd>
    </div>
  </div>
  <?php include('sidebar.php');?>
</div>
<script type="text/javascript" language="javascript" src="js/jcarousellite.js"></script> 
<script type="text/javascript" language="javascript" src="js/index.js"></script>
<?php include('footer.php');?>

<!--底部结束-->
</body>
</html>