<?php require_once(dirname(__FILE__).'/config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $cfg_webname; ?></title>
<meta name="author" content="<?php echo $cfg_author; ?>" />
<meta name="keywords" content="<?php echo $cfg_keyword; ?>" />
<meta name="description" content="<?php echo $cfg_description; ?>" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/minify.js"></script>
<script src="js/logger.js"></script>
<link type="text/css" rel="stylesheet" href="css/bdsstyle.css">
<link type="text/css" rel="stylesheet" href="css/jiathis_share.css">
</head>
<!--头部-->
<?php include('head.php');?>
<div class="hr10"></div>
<!--装修案例-->
<div class="Column">
  <div class="iTitle"> <em class="fyahei">装修案例<span>&nbsp;&nbsp;DESIGN</span></em> </div>
  <div class="hr10"></div>
  <div class="Column-100">
    <div class="iTag f88 fl">
      <dl class="style">
        <dt><span>Style</span><br>
          <b>设计风格</b></dt>
        <dd><a href="#" title="现代简约" target="_blank" rel="nofollow">现代简约</a></dd>
        <dd><a href="#" title="简欧" target="_blank" rel="nofollow">简欧</a></dd>
        <dd><a href="#" title="田园" target="_blank" rel="nofollow">田园</a></dd>
        <dd><a href="#" title="地中海" target="_blank" rel="nofollow">地中海</a></dd>
        <dd><a href="#" title="欧式" target="_blank" rel="nofollow">欧式</a></dd>
        <dd><a href="#" title="中式" target="_blank" rel="nofollow">中式</a></dd>
        <dd><a href="#" title="后现代" target="_blank" rel="nofollow">后现代</a></dd>
        <dd><a href="#" title="美式" target="_blank" rel="nofollow">美式</a></dd>
        <dd><a href="#" title="简美" target="_blank" rel="nofollow">简美</a></dd>
        <dd><a href="#" title="其他" target="_blank" rel="nofollow">其他</a></dd>
      </dl>
      <dl class="type">
        <dt><span>Type</span><br>
          <b>空间效果</b></dt>
        <dd><a href="#" title="小户型" target="_blank" rel="nofollow">小户型</a></dd>
        <dd><a href="#" title="二居" target="_blank" rel="nofollow">二居</a></dd>
        <dd><a href="#" title="三居" target="_blank" rel="nofollow">三居</a></dd>
        <dd><a href="#" title="复式" target="_blank" rel="nofollow">复式</a></dd>
        <dd><a href="#" title="大户型" target="_blank" rel="nofollow">大户型</a></dd>
        <dd><a href="#" title="样板间" target="_blank" rel="nofollow">样板间</a></dd>
        <dd><a href="#" title="商业空间" target="_blank" rel="nofollow">商业空间</a></dd>
        <dd><a href="#" title="其他" target="_blank" rel="nofollow">其他</a></dd>
      </dl>
      <dl class="area">
        <dt><span>Area</span><br>
          <b>装修面积</b></dt>
        <dd><a href="#" title="80㎡以下" target="_blank" rel="nofollow">80㎡以下</a></dd>
        <dd><a href="#" title="80-120㎡" target="_blank" rel="nofollow">80-120㎡</a></dd>
        <dd><a href="#" title="120-180㎡" target="_blank" rel="nofollow">120-180㎡</a></dd>
        <dd><a href="#" title="180-250㎡" target="_blank" rel="nofollow">180-250㎡</a></dd>
        <dd><a href="#" title="250-500㎡" target="_blank" rel="nofollow">250-500㎡</a></dd>
        <dd><a href="#" title="500㎡以上" target="_blank" rel="nofollow">500㎡以上</a></dd>
      </dl>
      <dl class="price">
        <dt><span>Design</span><br>
          <b>别墅设计</b></dt>
        <dd><a href="#" title="中式典雅" target="_blank" rel="nofollow">中式典雅</a></dd>
        <dd><a href="#" title="北美风情" target="_blank" rel="nofollow">北美风情</a></dd>
        <dd><a href="#" title="欧陆传奇" target="_blank" rel="nofollow">欧陆传奇</a></dd>
        <dd><a href="#" title="现代奢华" target="_blank" rel="nofollow">现代奢华</a></dd>
        <dd><a href="#" title="东南亚自然之美" target="_blank" rel="nofollow">东南亚自然之美</a></dd>
      </dl>
    </div>
  </div>
  <div class="hr10"></div>
  <ul class="Column-100 iCases">
    <?php
				$classid = 9;
				$s = "
					SELECT id,linkurl,classid,picurl,title,size,price,author
					FROM `#@__infoimg`
					WHERE (classid=$classid OR parentstr LIKE '%,$classid,%')
					AND  mainid='$lang'
					AND delstate=''
					AND checkinfo=true
					ORDER BY orderid DESC

				";
				$dosql->Execute($s);
				while($row = $dosql->GetArray())
				{
					if($row['linkurl']=='' and $cfg_isreurl!='Y') $gourl = 'image_article.php?cid='.$row['classid'].'&id='.$row['id'];
					else if($cfg_isreurl=='Y') $gourl = 'image_article-'.$row['classid'].'-'.$row['id'].'-1.html';
					else $gourl = $row['linkurl'];
				?>
    <li> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="imga"><img src="<?php echo $row['picurl']; ?>" alt="<?php echo $row['title']; ?>"></a> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="f14 dis" style="text-align:center;"><?php echo ReStrLen($row['title'],10,''); ?></a> <a class="iIcon des" rel="nofollow"><?php echo $row['author']; ?></a><em class="iIcon cost"><?php echo $row['price']; ?></em></li>
    <?php
				}
				?>
  </ul>
</div>
<div class="hr10"></div>
<div class="Column"> 
  <!--设计团队-->
  <div class="iColumn-L iTeam">
    <div class="iTitle"> <a href="list_article.php?cid=10" rel="nofollow" target="_blank" class="iMore">更多&gt;&gt;</a> <em class="fyahei">设计团队<span>&nbsp;&nbsp;TEAM</span></em> </div>
    <div class="Box">
      <div style="visibility: visible; overflow: hidden; position: relative; z-index: 2; left: 0px; width: 720px;" id="iTeam">
        <ul style="margin: 0px; padding: 0px; position: relative; list-style-type: none; z-index: 1; width: 2340px; left: -720px;">
          <?php
				$classid = 10;
				$s = "
					SELECT id,linkurl,classid,picurl,title,size
					FROM `#@__infoimg`
					WHERE (classid=$classid OR parentstr LIKE '%,$classid,%')
					AND  mainid='$lang'
					AND delstate=''
					AND checkinfo=true
					ORDER BY orderid DESC

				";
				$dosql->Execute($s);
				while($row = $dosql->GetArray())
				{
					if($row['linkurl']=='' and $cfg_isreurl!='Y') $gourl = 'image_article.php?cid='.$row['classid'].'&id='.$row['id'];
					else if($cfg_isreurl=='Y') $gourl = 'image_article-'.$row['classid'].'-'.$row['id'].'-1.html';
					else $gourl = $row['linkurl'];
				?>
          <li style="overflow: hidden; float: left; width: 150px; height: 175px;"> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="imga"><img src="<?php echo $row['picurl']; ?>" alt="<?php echo $row['title']; ?>"></a> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" rel="nofollow" class="f14"><?php echo $row['title']; ?></a><cite>[<?php echo $row['size']; ?>]</cite> <a rel="nofollow" href="#" title="预约" target="_blank" class="order">预约</a> <a href="#" rel="nofollow" target="_blank" class="book">咨询</a> </li>
          <?php
				}
				?>
        </ul>
      </div>
    </div>
    <a href="javascrip:void%280%29;" class="iTprev" rel="nofollow"></a> <a href="javascrip:void%280%29;" class="iTnext" rel="nofollow"></a> </div>
  <!--视频样板房-->
  <div class="iColumn-R iTab">
    <div class="ht"><cite class="one hover">视频样板房</cite><cite>户型解析</cite></div>
    <ul>
      <li class="first"> <a href="#" title="#" target="_blank" class="imga fl"><img src="images/thumb_1485.jpg" alt="#"></a> <a href="#" title="#" target="_blank" class="fb">常州道达尔装饰高清样板房</a> <em class="iIcon hits">211</em> </li>
      <li> <em class="fr">[430]</em> <a href="#" title="#" target="_blank" class="iIcon hits">茂业样板房视频</a> </li>
      <li> <em class="fr">[346]</em> <a href="#" title="#" target="_blank" class="iIcon hits">唯美韩式美宅</a> </li>
      <li> <em class="fr">[299]</em> <a href="#" title="#" target="_blank" class="iIcon hits">标准水电工程</a> </li>
    </ul>
    <ul>
      <?php
				$classid = 26;
				$s = "
					SELECT id,linkurl,classid,picurl,title,size,hits
					FROM `#@__infoimg`
					WHERE (classid=$classid OR parentstr LIKE '%,$classid,%')
					AND  mainid='$lang'
					AND delstate=''
					AND checkinfo=true
					ORDER BY orderid DESC
					limit 4
				";
				$dosql->Execute($s);
				$tmp_i = 0;
				while($row = $dosql->GetArray())
				{
					if($row['linkurl']=='' and $cfg_isreurl!='Y') $gourl = 'image_article.php?cid='.$row['classid'].'&id='.$row['id'];
					else if($cfg_isreurl=='Y') $gourl = 'image_article-'.$row['classid'].'-'.$row['id'].'-1.html';
					else $gourl = $row['linkurl'];
					
					if ($tmp_i == 0) {
						//第一个
						?>
						<li class="first"> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="imga fl"><img src="<?php echo $row['picurl']; ?>" alt="<?php echo $row['title']; ?>"></a> <a href="#" title="<?php echo $row['title']; ?>" target="_blank" class="fb"><?php echo ReStrLen($row['title'],10,''); ?></a> <em class="iIcon hits"><?php echo $row['hits']; ?></em> </li>
						<?php
					}else {
						//非第一个
						?>
						<li> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="iIcon hits"><?php echo ReStrLen($row['title'],10,''); ?></a> </li>
						<?php
					}
					
					$tmp_i++;
				}
		?>
    </ul>
  </div>
</div>
<div class="hr10"></div>
<div class="Column tc"><a href="#" title="把客户的家当作自己的家" target="_blank" class="imga"><img src="images/6e95253f00b92475.jpg" alt="把客户的家当作自己的家" border="0/"></a></div>
<div class="body_cont pr"> 
  <script type="text/javascript">
$(document).ready(function(){
	$(".CasesDiv ul li,.Mccase li").hover(function(){$(this).addClass('hover');},function(){$(this).removeClass('hover');});
	$(".Mcstop li").hover(function(){
		$(this).addClass("hover").siblings().removeClass("hover");
		var index=$(this).index();
		$(".itamul .itam").eq(index).show().siblings().hide();
		})
   

  //订单滚动
	var _wrap=$('.new_orders ul');
	var _interval=1000;
	var _moving;
	_wrap.hover(function(){ 
		clearInterval(_moving);
	},function(){ 
		_moving=setInterval(function(){ 
			var _field=_wrap.find('li:first');
			var _h=_field.height(); 
			_field.animate({marginTop:-_h+'px'},800,function(){
				_field.css('marginTop',0).appendTo(_wrap);
			}) 
		},_interval)
	}).trigger('mouseleave');
	  

	  

	

});

</script> 
  <!--方艺工程左-->
  <div class="engineering_tt pr fl"> <em class="fyahei"> 方艺工程 <span> PROGRAM</span> </em> </div>
  <div class="pr fl diagram">
    <h3 class="tl"><a href="#" class="pr fr more"></a>工艺图解</h3>
    <ul class="pr fl">
      <li><a class="pr fl" target="_blank" href="#"></a></li>
      <li><a class="pr fl" target="_blank" href="#"></a></li>
      <li><a class="pr fl" target="_blank" href="#"></a></li>
      <li><a class="pr fl" target="_blank" href="#"></a></li>
    </ul>
  </div>
  <!--方艺工程中-->
  <div class="work_place pr fl">
    <p class="work_place_tt pr fl tl"> <a href="#" class="pr fr more"></a></p>
    <ul class="pr fl">
      <li class="first"> <a href="#" title="#" target="_blank"><img src="images/thumb_9079.jpg" alt="#" border="0"></a>
        <p><a href="#" title="#" target="_blank">油漆工艺：丹麦风格白擦金工艺</a></p>
      </li>
      <li> <a href="#" title="#" target="_blank"><img src="images/thumb_9078.jpg" alt="#" border="0"></a>
        <p><a href="#" title="#" target="_blank">油漆工艺：幻彩橱柜风格</a></p>
      </li>
      <li> <a href="#" title="#" target="_blank"><img src="images/thumb_8415.jpg" alt="#" border="0"></a>
        <p><a href="#" title="#" target="_blank">成品保护工艺视频</a></p>
      </li>
      <li> <a href="#" title="#" target="_blank"><img src="images/thumb_8411.jpg" alt="#" border="0"></a>
        <p><a href="#" title="#" target="_blank">施工现场</a></p>
      </li>
      <li> <a href="#" title="#" target="_blank"><img src="images/thumb_8412.jpg" alt="#" border="0"></a>
        <p><a href="#" title="#" target="_blank">水路工艺视频</a></p>
      </li>
    </ul>
  </div>
  <!--服务小区-->
  <div class="new_orders pr fr">
    <p class="new_orders_tt pr fl tl"> <a href="#" class="pr fr" rel="nofollow">我要装修设计</a></p>
    <p class="new_orders_msg pr fl tc">服务小区288 个  服务业主385 人</p>
    <ul class="pr fl">
      <?php
				$classid = 27;
				$s = "
					SELECT linkurl,classid,id,posttime,title,colorval,boldval,picurl,content
					FROM `#@__infolist`
					WHERE (classid=$classid or parentid=$classid)
					AND  mainid='$lang'
					AND delstate=''
					AND checkinfo=true
					ORDER BY orderid DESC
				";
				$dosql->Execute($s);
				while($row = $dosql->GetArray())
				{
					if($row['linkurl']=='' and $cfg_isreurl!='Y') $gourl = 'article_article.php?cid='.$row['classid'].'&id='.$row['id'];
					else if($cfg_isreurl=='Y') $gourl = 'article_article-'.$row['classid'].'-'.$row['id'].'-1.html';
					else $gourl = $row['linkurl'];
				?>
      <li>
        <h3 class="tl"><?php echo $row['title']; ?></h3>
        <h4><span>面积：<?php echo $row['mianji']; ?>㎡</span> <span>预算：<?php echo $row['yusuan']; ?>万元</span></h4>
      </li>
      <?php
				}
				?>
    </ul>
  </div>
</div>
<div class="Column" style="margin-top:15px;"> 
  <!--业主评价-->
  <div class="iColumn-L">
    <div class="iTitle"> <a href="list_article.php?cid=32" rel="nofollow" target="_blank" class="iMore">更多&gt;&gt;</a> <em class="fyahei">业主评价<span>&nbsp;&nbsp;COMMENT</span></em> </div>
    <ul class="iThink fl">
      <?php
				$classid = 32;
				$s = "
					SELECT id,linkurl,classid,picurl,title,size,content
					FROM `#@__infoimg`
					WHERE (classid=$classid OR parentstr LIKE '%,$classid,%')
					AND  mainid='$lang'
					AND delstate=''
					AND checkinfo=true
					ORDER BY orderid DESC
					LIMIT 0,2
				";
				$dosql->Execute($s);
				while($row = $dosql->GetArray())
				{
					if($row['linkurl']=='' and $cfg_isreurl!='Y') $gourl = 'image_article.php?cid='.$row['classid'].'&id='.$row['id'];
					else if($cfg_isreurl=='Y') $gourl = 'image_article-'.$row['classid'].'-'.$row['id'].'-1.html';
					else $gourl = $row['linkurl'];
				?>
      <li> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="imga fl"><img src="<?php echo $row['picurl']; ?>" alt="<?php echo $row['title']; ?>"></a> <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="imga f14"><?php echo ReStrLen($row['title'],10,''); ?></a>
        <p><?php echo ReStrLen($row['content'],10,''); ?></p>
        <a href="<?php echo $gourl; ?>" title="<?php echo $row['title']; ?>" target="_blank" class="iView fl">VIEW</a> <em class="iIcon time"><?php echo date("y-m-d",$row['posttime']); ?></em> </li>
      <?php
				}
				?>
    </ul>
  </div>
  <!--预约装修-->
  <div class="iColumn-R iIndent"> 
    <script type="text/javascript">
        function change(obj) {
				$(".qwe").hide();
				$("#news"+obj).show();
			}
     </script>
    <div class="ht fyahei"> <span><a href="javascript:void(0);" onmousemove="change(1)" class="spana">预约装修</a> <a href="javascript:void(0);" onmousemove="change(2)">预约参观</a></span> </div>
    <form method="post" action="?c=post&amp;f=setok&amp;module_id=119&amp;totype=alert" onsubmit="return to_submit();" class="qwe" id="news1" style="display:block;">
      <input id="tourl" name="tourl" value="goback" type="hidden">
      <input id="tomsg" name="tomsg" value="预约成功，我们将通过电话联系您！" type="hidden">
      <input id="subject" name="subject" value="来源：首页客户订单" type="hidden">
      <div class="table ext cls_contact">
        <div class="left"><span class="red">*</span> 称呼：</div>
        <div class="right">
          <div>
            <table cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td><input class="input-text" name="contact" id="contact" style="width:150px;" type="text"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="table ext cls_phone">
        <div class="left"><span class="red">*</span> 手机：</div>
        <div class="right">
          <div>
            <table cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td><input class="input-text" name="phone" id="phone" style="width:150px;" type="text"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="table ext cls_cost">
        <div class="left">预算：</div>
        <div class="right">
          <div>
            <table cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td><input class="input-text" name="cost" id="cost" style="width:150px;" type="text"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="table">
        <div class="left">&nbsp;</div>
        <input class="button" id="_phpok_submit" value="预约" type="submit">
      </div>
    </form>
    <form method="post" action="?c=post&amp;f=setok&amp;module_id=119&amp;totype=alert" onsubmit="return to_submit();" class="qwe" id="news2" style="display:none;">
      <input id="tourl" name="tourl" value="goback" type="hidden">
      <input id="tomsg" name="tomsg" value="预约成功，我们将通过电话联系您！" type="hidden">
      <input id="subject" name="subject" value="来源：首页客户订单" type="hidden">
      <div class="table ext cls_contact">
        <div class="left"><span class="red">*</span> 姓名：</div>
        <div class="right">
          <div>
            <table cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td><input class="input-text" name="contact" id="contact" style="width:150px;" type="text"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="table ext cls_phone">
        <div class="left"><span class="red">*</span> 电话：</div>
        <div class="right">
          <div>
            <table cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td><input class="input-text" name="phone" id="phone" style="width:150px;" type="text"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="table ext cls_cost">
        <div class="left">预算：</div>
        <div class="right">
          <div>
            <table cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td><input class="input-text" name="cost" id="cost" style="width:150px;" type="text"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="table">
        <div class="left">&nbsp;</div>
        <input class="button" id="_phpok_submit" value="预约设计" type="submit">
      </div>
    </form>
    <script type="text/javascript" src="js/php.js"></script> 
    <script type="text/javascript">
			
function to_submit()
{
	var subject = getid("subject").value;
	if(!subject)
	{
		alert("主题不允许为空");
		getid("subject").focus();
		return false;
	}
						var contact = getid("contact").value;
				if(!contact)
		{
			alert("请填写您的姓名");
			getid("contact").focus();
			return false;
		}
							var phone = getid("phone").value;
				if(!phone)
		{
			alert("手机号码未填写或填写错误");
			getid("phone").focus();
			return false;
		}
					getid("_phpok_submit").disabled = true;
	return true;
}
</script> 
  </div>
</div>
<!--合作品牌-->
<div class="brands pr"> <span class="pr fl tl"><em class="fyahei"> 合作品牌 <span> COOPERATION BRAND</span> </em> </span>
  <ul class="pr fl pic_link">
    <?php
				$classid = 4;
				$s = "
					SELECT id,linkurl,classid,picurl,title,size
					FROM `#@__infoimg`
					WHERE (classid=$classid OR parentstr LIKE '%,$classid,%')
					AND  mainid='$lang'
					AND delstate=''
					AND checkinfo=true
					ORDER BY orderid DESC

				";
				$dosql->Execute($s);
				while($row = $dosql->GetArray())
				{
					if($row['linkurl']=='' and $cfg_isreurl!='Y') $gourl = 'image_article.php?cid='.$row['classid'].'&id='.$row['id'];
					else if($cfg_isreurl=='Y') $gourl = 'image_article-'.$row['classid'].'-'.$row['id'].'-1.html';
					else $gourl = $row['linkurl'];
				?>
    <li><a class="pr fl" href="javascript:void(0);" target="_blank" rel="nofollow"><img src="<?php echo $row['picurl']; ?>" title="<?php echo $row['title']; ?>" /></a></li>
    <?php
				}
				?>
  </ul>
</div>
<script type="text/javascript" language="javascript" src="js/jcarousellite.js"></script> 
<script type="text/javascript" language="javascript" src="js/index.js"></script>
<?php include('footer.php');?>
</body></html>