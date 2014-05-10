<div class="Column-L">
<?php
@$sideCID = (int)$_REQUEST['cid'];
//$root_class 为根节点 ; $cur_class 为当前节点
$root_class = $cur_class = array();
if ($sideCID > 0) {
	$cur_class = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id='".$sideCID."'");
	$root_class =  getrootclass($sideCID);
}

//递归查询父级根节点
function getrootclass($nowid) {
	global $dosql;
	$class_info = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id='".$nowid."'");
	if ($class_info['parentid'] > 0) {
		$class_info = getrootclass($class_info['parentid']);
	}
	return $class_info;
}
$s = "SELECT * FROM `#@__infoclass`
	WHERE (classid=$classid OR parentstr LIKE '%,$classid,%')
	AND  mainid='$lang'
	AND delstate=''
	AND checkinfo=true
	ORDER BY orderid DESC";
?>
<div class="ht1">关于我们</div>
<ul class="CateList">
  <li><a href="#" class="current">公司简介</a></li>
   
  <li><a href="#">走进道达尔工厂</a></li>
   
  <li><a href="#">公司文化</a></li>
   
  <li><a href="#">公司历程</a></li>
   
  <li><a href="#">公司荣誉</a></li>
   
  <li><a href="#">人才招聘</a></li>
   
  <li><a href="#">联系我们</a></li>
  </ul>
<div class="hr10"></div>


<div class="sTag pTag f88">
<div class="iIcon ht"><em>热门标签</em><i>Tag</i></div>
	<?php
	$classid = 9; //装修案例的栏目编号
	$anli_arr = array(
		'sjfg'=>array('cn'=>'设计风格','en'=>'Style','class'=>'style'),
		'kjxg'=>array('cn'=>'空间效果','en'=>'Type','class'=>'type'),
		'zxmj'=>array('cn'=>'装修面积','en'=>'Area','class'=>'area'),
		'bssj'=>array('cn'=>'别墅设计','en'=>'Design','class'=>'price'),
	);
	foreach ($anli_arr as $fieldname=>$titnames) {
		echo '<dl class="'.$titnames['class'].'">';
		echo '<dt><span>'.$titnames['en'].'</span><br><b>'.$titnames['cn'].'</b></dt>';
		
		$row = $dosql->GetOne("SELECT * FROM `#@__diyfield` WHERE fieldname='".$fieldname."'");
		$fieldsel = explode(',', $row['fieldsel']);
		$tmp_i = 0;
		foreach($fieldsel as $k=>$fieldsel_arr) {
			$fieldsel_val = explode('=', $fieldsel_arr);
			//$fieldsel_val[0] 此为显示的值   $fieldsel_val[1] 此为字段的值
			
			if ($cfg_isreurl!='Y') $gourl = 'list_image.php?cid='.$classid.'&'.$fieldname.'='.$fieldsel_val[1];
			else $gourl = 'list_image-'.$classid.'-1.html'; //伪静态没写, 待完成
			
			$tmp_str = (@$tmp_i%3 === 0) ? '' : ' class="col"';
			$tmp_i++;
			echo '<a href="'.$gourl.'" title="'.$fieldsel_val[0].'" target="_blank" rel="nofollow"'.$tmp_str.'>'.$fieldsel_val[0].'</a>';
		}
		echo '</dl>';
	}
	?>
</div>
<div class="hr10"></div><div class="pSer">
<a href="#" title="委托设计" target="_blank" rel="nofollow" class="order">委托设计</a>
<a href="#" title="咨询留言" target="_blank" rel="nofollow" class="book">咨询留言</a>
</div>
<div class="hr10"></div></div>