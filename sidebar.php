<div class="Column-L">
<?php
@$sideCID = (int)$_REQUEST['cid'];
//$root_class 为根节点 ; $cur_class 为当前节点
$root_class = $cur_class = array();
if ($sideCID > 0) {
	
	$cur_class = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id='".$sideCID."'");
	$root_class =  getrootclass($sideCID);
	
	$class_arr = array('1','2','3','4','21');
	if (!in_array($root_class['id'],$class_arr)) {
		$root_class = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id='1'");
	}
	
	$infotype = array('single_article','list_article','list_image');
	
	echo '<div class="ht1">'.$root_class['classname'].'</div>';
	echo '<ul class="CateList">';
	$s = "SELECT * FROM `#@__infoclass` WHERE parentid=".$root_class['id']." AND checkinfo=true ORDER BY orderid";
	$dosql->Execute($s); $tmpsql = new MySql(false);
	while($son = $dosql->GetArray()) {
		$tmp = (in_array($son['id'],explode(',',$cur_class['parentstr'])) || $son['id'] == $cur_class['id']) ? 'current' : '';
		$gdsonstr = '';
		$s = "SELECT * FROM `#@__infoclass` WHERE parentid=".$son['id']." AND checkinfo=true ORDER BY orderid";
		$tmpsql->Execute($s);
		while($gdson = $tmpsql->GetArray()) {
			$gdtmp = (in_array($gdson['id'],explode(',',$cur_class['parentstr'])) || $gdson['id'] == $cur_class['id']) ? 'current' : '';
			
			if($gdson['linkurl']=='' and $cfg_isreurl!='Y') $gourl = $infotype[$gdson['infotype']].'.php?cid='.$gdson['id'];
			else if($cfg_isreurl=='Y') $gourl =  $infotype[$gdson['infotype']].'-'.$gdson['id'].'-1.html';
			else $gourl = $gdson['linkurl'];
			
			$gdsonstr .= '<li class="subCate"><a href="'.$gourl.'" title="'.$gdson['classname'].'" class="'.$gdtmp.'">+&nbsp;&nbsp;&nbsp;&nbsp;'.$gdson['classname'].'</a></li>';
		}
		
		if($son['linkurl']=='' and $cfg_isreurl!='Y') $gourl = $infotype[$son['infotype']].'.php?cid='.$son['id'];
		else if($cfg_isreurl=='Y') $gourl =  $infotype[$son['infotype']].'-'.$son['id'].'-1.html';
		else $gourl = $son['linkurl'];
		echo '<li><a href="'.$gourl.'" title="'.$son['classname'].'" class="'.$tmp.'">'.$son['classname'].'</a></li>';
		echo $gdsonstr;
	}
	echo '</ul>';
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

?>

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
<a href="message.php" title="委托设计" target="_blank" rel="nofollow" class="order">委托设计</a>
<a href="message.php" title="咨询留言" target="_blank" rel="nofollow" class="book">咨询留言</a>
</div>
<div class="hr10"></div></div>