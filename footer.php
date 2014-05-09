<div class="Column-100 Footer tc">
  <div class="Column fBanner"><img src="images/Banner_foot.png"></div>
  <div class="footer_bottom">
    <div class="friend_link">
      <p>友情链接：</p>
      <ul>
        <?php
$dosql->Execute("SELECT * FROM `#@__weblink` WHERE classid=1 AND checkinfo=true ORDER BY orderid,id DESC");
while($r = $dosql->GetArray())
{
?>
        <li><a href="<?php echo $r['linkurl'];?>"><?php echo $r['webname']; ?></a></li>
        <?php
    }
    ?>
      </ul>
    </div>
    <div class="Column Menu fyahei"> <a rel="nofollow" href="#" title="施工图解" class="col_1">施工图解</a> <a rel="nofollow" href="#" title="预约装修" class="col_2">预约装修</a> <a rel="nofollow" href="#" title="在线咨询" class="col_3">在线咨询</a> <a rel="nofollow" href="#" title="维修申请" class="col_4">维修申请</a> <a rel="nofollow" href="#" title="关于我们" class="col_5">关于我们</a> <a rel="nofollow" href="#" title="联系我们" class="col_6">联系我们</a> </div>
    <div class="Column Copy">
      <p class="fyahei"> <span class="fff fb">电话 | TEL</span>&nbsp;&nbsp;0379-60125958&nbsp;       &nbsp;&nbsp;&nbsp;&nbsp;<span class="fff fb">地址 | ADD</span>&nbsp;&nbsp;洛阳市西工区九都路71号申泰新世纪广场A座921、922、923室</p>
      <p class="f12">CopyRight 2010-2012 All Right Reserved 方艺装饰 版权所有 </p>
      技术支持：洛阳千成网络科技有限公司<a href="/mgr">【后台管理】</a></div>
  </div>
</div>
