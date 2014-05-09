<?php	if(!defined('IN_SITE')) exit("Request Error!");

/*
 * 函数说明：单页信息调用
 *
 * @access  public
 * @param   $classid  int     类别ID
 * @param   $length   int     字数显示 0或空为不限制
 * @param   $moreLink string  跳转连接
 * @return            string  返回单页内容
 */
function Info($classid, $length=0, $moreLink='')
{
    global $dosql,$lang;
    $contstr = '';
	 if (!isset($lang)) $lang = -1;

    $row = $dosql->GetOne("SELECT * FROM `#@__info` WHERE classid=$classid AND mainid = '$lang'");
    if(isset($row['content']))
    {
        if(!empty($length))
        {
            $contstr .= ReStrLen(strip_tags($row['content']), $length);
        }
        else
        {
            return GetContPage($row['content']);
        }
        if($moreLink != '') $contstr .= '<a href="'.$moreLink.'">[更多>>]</a>';
    }
    else
    {
        $contstr .= t('网站资料更新中...',$lang);
    }
    
    return $contstr;
}


/*
 * 函数说明：获取内容分页
 *
 * @access  public
 * @param   $content  string  设置分页内容
 * @return            string  返回替换后内容
 */
function GetContPage($content)
{
    global $cfg_isreurl;

    //设定分页标签
    $contstr  = '';
    $nextpage = '<hr style="page-break-after:always;" class="ke-pagebreak" />';


    if(strpos($content, $nextpage))
    {
        $contarr   = explode($nextpage, $content);
        $totalpage = count($contarr);
    
        if(!isset($_GET['page']) || !intval($_GET['page']) || $_GET['page'] > $totalpage) $page = 1;
        else $page = $_GET['page'];
    
        //输出内容
        $contstr .= $contarr[$page-1];

        //获取除page参数外的其他参数
        $query_str = explode('&',$_SERVER["QUERY_STRING"]);

        if($query_str[0] != '')
        {
            $query_strs = '';

            foreach($query_str as $k)
            {
                $query_str_arr = explode('=', $k);

                if(strstr($query_str_arr[0],'page') == '')
                {
                    $query_str_arr[0] = isset($query_str_arr[0]) ? $query_str_arr[0] : '';
                    $query_str_arr[1] = isset($query_str_arr[1]) ? $query_str_arr[1] : '';

                    //伪静态设置
                    if($cfg_isreurl != 'Y')
                    {
                        $query_strs .= $query_str_arr[0].'='.$query_str_arr[1].'&';		
                    }
                    else
                    {
                        $query_strs .= '-'.$query_str_arr[1];	
                    }
                }
            }

            $nowurl = '?'.$query_strs;
        }
        else
        {
            $nowurl = '?';
        }

        //伪静态设置
        if($cfg_isreurl == 'Y')
        {
            $request_arr  = explode('/',$_SERVER['REQUEST_URI']);
            $request_cont = count($request_arr);
            $request_rui  = explode('-', $request_arr[$request_cont-1]);
            $nowurl = ltrim($request_rui[0],'/').ltrim($nowurl,'?');
        }
        
        $previous = $page - 1;
        if($totalpage == $page) $next = $page;
        else $next = $page + 1;

        $page_content = '<div class="contPage">';

        //显示首页的裢接
        if($page > 1)
        {
            //伪静态设置
            if($cfg_isreurl != 'Y')
            {
                $page_content .= '<a href="'.$nowurl.'page=1">&lt;&lt;</a>';
                $page_content .= '<a href="'.$nowurl.'page='.$previous.'">&lt;</a>';
            }
            else
            {
                $page_content .= '<a href="'.$nowurl.'-1.html">&lt;&lt;</a>';
                $page_content .= '<a href="'.$nowurl.'-'.$previous.'.html">&lt;</a>';
            }
        }
        else
        {
            $page_content .= '<a href="javascript:;">&lt;&lt;</a>';
            $page_content .= '<a href="javascript:;">&lt;</a>';
        }

        //显示数字页码
        for($i=1; $i<=$totalpage; $i++)
        {
            if($page == $i)
            {
                $page_content .= '<a href="javascript:;" class="on">'.$i.'</a>';
            }
            else
            {
                //伪静态设置
                if($cfg_isreurl != 'Y')
                {
                    $page_content .= '<a href="'.$nowurl.'page='.$i.'" class="num">'.$i.'</a>';
                }
                else
                {
                    $page_content .= '<a href="'.$nowurl.'-'.$i.'.html" class="num">'.$i.'</a>';
                }
            }
        }

        //显示尾页的裢接
        if($page < $totalpage)
        {
            //伪静态设置
            if($cfg_isreurl != 'Y')
            {
                $page_content .= '<a href="'.$nowurl.'page='.$next.'">&gt;</a>';
                $page_content .= '<a href="'.$nowurl.'page='.$totalpage.'">&gt;&gt;</a>';
            }
            else
            {
                $page_content .= '<a href="'.$nowurl.'-'.$next.'.html">&gt;</a>';
                $page_content .= '<a href="'.$nowurl.'-'.$totalpage.'.html">&gt;&gt;</a>';
            }
        }
        else
        {
            $page_content .= '<a href="javascript:;">&gt;</a>';
            $page_content .= '<a href="javascript:;">&gt;&gt;</a>';
        }
        $page_content .= '</div>';

        $contstr .= $page_content;
    }
    else
    {
        $contstr .= $content;
    }

    return $contstr;
}


/*
 * 栏目SEO头部调用
 *
 * @access  public
 * @param   $classid  int     当前页面栏目id
 * @param   $id       int     是否为内容页(非0即是)
 * @return            string  返回头部区域代码
 */
function GetHeader($classid=0, $id=0)
{
    global $dosql, $cfg_webname, $cfg_generator, $cfg_author, $cfg_keyword, $cfg_description;

    if(!empty($id))
    {
        $r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id=$classid");
        
        if(!empty($r['infotype']))
        {
            if($r['infotype'] == 1)
            {
                $tbname = '#@__infolist';
            }
            else if($r['infotype'] == 2)
            {
                $tbname = '#@__infoimg';
            }
            else if($r['infotype'] == 3)
            {
                $tbname = '#@__soft';
            }
    
            $r2 = $dosql->GetOne("SELECT * FROM `$tbname` WHERE id=$id");
        
            $header_str = '<title>';
        
            if(!empty($r2['title']))
            {
                $header_str .= $r2['title'].' - ';
            }
        
            if(!empty($r['classname']))
            {
                $header_str .= $r['classname'].' - ';
            }
        
            $header_str .= $cfg_webname.'</title>'."\n";
            $header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
            $header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
            $header_str .= '<meta name="keywords" content="';
            
            if(!empty($r2['keywords']))
            {
                $header_str .= $r2['keywords'];
            }
            else
            {
                $header_str .= $cfg_keyword;
            }
        
            $header_str .= '" />'."\n";
        
            $header_str .= '<meta name="description" content="';
            
            if(!empty($r2['description']))
            {
                $header_str .= $r2['description'];
            }
            else
            {
                $header_str .= $cfg_description;
            }
        
            $header_str .= '" />'."\n";
        }
        else
        {
            return '';
        }
    }
    else
    {
        $r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id=$classid");

        $header_str = '<title>';
    
        if(!empty($r['seotitle']))
        {
            $header_str .= $r['seotitle'];
        }
        else if(!empty($r['classname']))
        {
            $header_str .= $r['classname'].' - '.$cfg_webname;
        }
        else
        {
            $header_str .= $cfg_webname;
        }
    
        $header_str .= '</title>'."\n";
        $header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
        $header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
        $header_str .= '<meta name="keywords" content="';
        
        if(!empty($r['keywords']))
        {
            $header_str .= $r['keywords'];
        }
        else
        {
            $header_str .= $cfg_keyword;
        }
    
        $header_str .= '" />'."\n";
    
        $header_str .= '<meta name="description" content="';
        
        if(!empty($r['description']))
        {
            $header_str .= $r['description'];
        }
        else
        {
            $header_str .= $cfg_description;
        }
    
        $header_str .= '" />'."\n";
    }
    
    return $header_str;
}


/*
 * 获取当前页面位置
 *
 * @access  public
 * @param   $cid     int     当前页面栏目id
 * @param   $iscont  int     是否为内容页(非0即是)
 * @param   $sign    string  栏目之间分隔符
 * @return           string
 */
function GetPosStr($cid,$iscont=0,$sign='&gt;&gt;')
{
    global $dosql, $cfg_isreurl, $cfg_reurl_index;
    
    $sign = '&nbsp;'.$sign.'&nbsp;';
    
    if($cfg_isreurl == 'Y')
    {
        $index = $cfg_reurl_index;
    }
    else
    {
        $index = 'index.php';
    }
    $pos_str = '<a href="'.$index.'">首页</a>';


    $r = $dosql->GetOne("SELECT * FROM `#@__infoclass` where id=$cid");

    if(empty($r['parentstr']))
    {
        return $pos_str.$sign.'参数获取出错';
    }

    if($r['parentstr'] != '0,')
    {
        $pid_arr = explode(',', $r['parentstr']);

        foreach($pid_arr as $v)
        {
            if(!empty($v))
            {
                $r = $dosql->GetOne("SELECT `linkurl`,`classname` FROM `#@__infoclass` where id=$v");
                if (!empty($r['linkurl'])){
                    $pos_str .= $sign.'<a href="'.$r['linkurl'].'">'.$r['classname'].'</a>';
                }else{
                    $pos_str .= $sign.$r['classname'];
                }
            }
        }
        
        $r = $dosql->GetOne("SELECT * FROM `#@__infoclass` where id=$cid");
    
    }
    
    if($iscont != 0)
    {
        return $pos_str.$sign.$r['classname'].$sign.'<strong>详细内容</strong>';
    }
    else
    {
        return $pos_str.$sign.'<strong>'.$r['classname'].'</strong>';
    }
}

/* 半成品
// 根据自定义菜单输入当前位置
function GetPosition($cid,$iscont=0,$sign='&gt;&gt;'){
    global $dosql, $cfg_isreurl, $cfg_reurl_index;
    $sign = '&nbsp;'.$sign.'&nbsp;';
    if($cfg_isreurl == 'Y'){
        $index = $cfg_reurl_index;
    }else{
        $index = 'index.php';
    }
    $pos_str = '<a href="'.$index.'">首页</a>';
    $r = $dosql->GetOne("SELECT * FROM `#@__nav` where id=$cid");
    if(empty($r['parentstr'])){
        return $pos_str.$sign.'参数获取出错';
    }

    if($r['parentstr'] != '0,'){
        $pid_arr = explode(',', $r['parentstr']);
        foreach($pid_arr as $v){
            if(!empty($v)){
                $r = $dosql->GetOne("SELECT `classname` FROM `#@__nav` where id=$v");
                $pos_str .= $sign.$r['classname'];
            }
        }
        $r = $dosql->GetOne("SELECT * FROM `#@__nav` where id=$cid");
    }
    if($iscont != 0){
        return $pos_str.$sign.$r['classname'].$sign.'<strong>详细内容</strong>';
    }else{
        return $pos_str.$sign.'<strong>'.$r['classname'].'</strong>';
    }
}
*/
/*
*函数说明：返回当前栏目名称
*@return string 返回当前栏目名称
*@param $cid 当前栏目编号
*/
function GetCatName($cid){
	global $dosql;
	$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id = '$cid'");
	return $r['classname'];
}
/*
 * 参数说明：返回顶部按钮
 *
 * @return  string  返回HTML代码
 */
function GetBackTop(){
	return $html = '
		<link href="data/plugin/backtop/backtop.css" type="text/css" rel="stylesheet" charset="utf-8">
		<p id="backTop">
			<a href="#top"><span></span>Back to Top</a>
		</p>
		<script>
		$(function(){
			$("#backTop").hide();
			$(function () {
				$(window).scroll(function () {
					if ($(this).scrollTop() > 100) {
						$("#backTop").fadeIn();
					} else {
						$("#backTop").fadeOut();
					}
				});
				$("#backTop a").click(function () {
					$("body,html").animate({
						scrollTop: 0
					}, 200);
					return false;
				});
			});
		});
		</script>
	';
}

/*
 * 参数说明：获取客服QQ
 *
 * @access  public
 * @return  string  返回HTML代码
 */
function GetQQ($useDefaultStyle = TRUE)
{
    global $cfg_qqcode,$cfg_qqcodeimg;

    if(!empty($cfg_qqcode))
    {
        $re_str = '';
        if ($useDefaultStyle) $re_str = '
		  <link href="data/plugin/kf/kf.css" type="text/css" rel="stylesheet" charset="utf-8">
		  <div class="kf"><div class="kf_r">';
        $qqnum_arr = explode(',', $cfg_qqcode);

        foreach($qqnum_arr as $v)
        {
            $qq_arr = explode('|',$v);
            if(!empty($qq_arr[0]) and !empty($qq_arr[1]))
            {
                $re_str .= ' <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq_arr[0].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$v.':'.$cfg_qqcodeimg.'" alt="'.$qq_arr[1].'" title="'.$qq_arr[1].'"></a>';
            }
            else if(!empty($qq_arr[0]) and empty($qq_arr[1]))
            {
                $re_str .= ' <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq_arr[0].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$v.':'.$cfg_qqcodeimg.'" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
            }
            else
            {
                $re_str .= ' <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$v.'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$v.':'.$cfg_qqcodeimg.'" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
            }
        }
        if ($useDefaultStyle) $re_str .= '</div></div>';
        
        return $re_str;
    }
}


//获取parentstr的第一位
function GetTopID($str,$i=1)
{
    if($str == '0,')
    {
        $topid = 0;
    }
    else
    {
        $ids = explode(',', $str);
        $topid = isset($ids[$i]) ? $ids[$i] : '';
    }
    
    return $topid;
}


/*
 * 函数说明：获取一级导航
 *
 * @access  public
 * @param   $id  int  父ID
 * @return  string    返回导航
 */
function GetNav($pid=1,$useLi = TRUE)
{
    global $dosql, $cfg_isreurl;

    $str = '';
    $dosql->Execute("SELECT * FROM `#@__nav` WHERE parentid=$pid AND checkinfo=true ORDER BY orderid ASC");
    while($row = $dosql->GetArray())
    {
        if($cfg_isreurl != 'Y')
        {
            $gourl = $row['linkurl'];
        }
        else
        {
            $gourl = $row['relinkurl'];
        }
        
        if($row['picurl'] != '')
        {
            $classname = $row['picurl'];
        }
        else
        {
            $classname = $row['classname'];
        }

        if ($useLi){
            $str .= '<li><a href="'.$gourl.'">'.$classname.'</a><ul class="nav_sub">'.GetSubNav($row['id']).'</ul></li>';
        }else{
				$str .= '<a href="'.$gourl.'">'.$classname.'</a> ';
        }
    }

    return $str;
}


/*
 * 函数说明：获取导航菜单
 *
 * @access  public
 * @param   $id  int  父ID
 * @return  string    返回导航
 */
function GetSubNav($id)
{
    global $dosql, $cfg_isreurl;

    $str = '';
    $row = $dosql->Execute("SELECT * FROM `#@__nav` WHERE parentid=$id AND checkinfo=true ORDER BY orderid ASC", $id);
    while($row = $dosql->GetArray($id))
    {
        if($cfg_isreurl != 'Y')
        {
            $gourl = $row['linkurl'];
        }
        else
        {
            $gourl = $row['relinkurl'];
        }
        
        if($row['picurl'] != '')
        {
            $classname = $row['picurl'];
        }
        else
        {
            $classname = $row['classname'];
        }
        
        $str .= '<li><a href="'.$gourl.'">'.$classname.'</a>';

        $row2 = $dosql->Execute("SELECT * FROM `#@__nav` WHERE parentid=".$row["id"]." AND checkinfo=true ORDER BY orderid DESC", $row['id']);
        if($dosql->GetTotalRow($row['id']))
        {
            $str .= '<ul class="s">'.GetSubNav($row["id"]).'</ul>';
        }
        $str .= '</li>';
    }

    return $str;
}
/*
 * 函数说明：取一条文档信息（点击数会自动增加一次点击）
 *
 * @access  public
 * @param   $arcId  int  文档ID
 * @param   $tableName  string  数据表名（infolist,imfoimg,goods,soft）
 * @return  int 点击数
 */
function GetArticle($arcId = 0,$tableName='infolist'){
    global $dosql,$lang;
 	 if (!isset($lang)) $lang = -1;
    $arcId = (int)$arcId;
    if (empty($arcId) && isset($_GET['id'])) $arcId = $_GET['id'];
    // 检测表名
    $tableArray = array('infolist','infoimg','goods','soft');
    if (!in_array($tableName,$tableArray)) $tableName = $tableArray[0];
    // 检测文档正确性
    $r = $dosql->GetOne("SELECT hits FROM `#@__$tableName` WHERE id='$arcId' AND mainid = '$lang'");
    if(@$r){
        //增加一次点击量
        $dosql->ExecNoneQuery("UPDATE `#@__$tableName` SET hits=hits+1 WHERE id='$arcId'");
        return $r;
    }
    return array(
        'title'=>'文档不存在',
        'content'=>'文档不存在',
    );
}
/*
 * 函数说明：取文档列表中的链接
 *
 * @access  public
 * @param   $arcId  int  文档ID
 * @param   $tableName  string  数据表名（infolist,imfoimg,goods,soft）
 * @return  int 点击数
 */
function GetListArcUrl($tableName = 'infolist',$classId = 0,$articleId = 0){
    global $cid,$id; // Notice:在用while循环$rs时，定义这二个变量，以结束时清零
    if (empty($classId) && !empty($cid) && isset($cid)) $classId = $cid;
    if (empty($articleId) && !empty($id) && isset($id)) $articleId = $id;
    // 检测表名
    $tableArray = array('infolist','infoimg','goods','soft');
    if (!in_array($tableName,$tableArray)) $tableName = $tableArray[0];
    // 显示内容的脚本文件名
    $scriptArray = array(
        'infolist'=>'newsshow',
        'infoimg'=>'productshow',
        'goods'=>'goodsshow',
        'soft'=>'softshow'
    );
    $scriptName = $scriptArray[$tableName]; // 不含扩展名“.php”
    // 输出URL
    if($row['linkurl']=='' and $cfg_isreurl!='Y')
        $gourl = $scriptName.'.php?cid=$cid&id=$aid';
    else if($cfg_isreurl=='Y')
        $gourl = $scriptName.'-'.$cid.'-'.$aid.'-1.html';
    else
        $gourl = $row['linkurl'];
    return $gourl;
}
/*
 * 函数说明：取上一条和下一条
 *
 * @access  public
 * @param   $arcId  int  文档ID
 * @param   $tableName  string  数据表名（infolist,infoimg,goods,soft）
 * @return  int 点击数
 */
function GetPN($arcId = 0,$tableName='infolist',$scriptName = ''){ // pn:PreAndNext
    global $dosql,$lang,$cfg_isreurl;
    $arcId = (int)$arcId;
 	 if (!isset($lang)) $lang = -1;
    if (empty($arcId) && isset($_GET['id'])) $arcId = $_GET['id'];
    $html = '';
    $scriptName = basename($_SERVER['SCRIPT_NAME'],'.php');
    // 取classid
    $rs = $dosql->GetOne("SELECT classid FROM `#@__$tableName` WHERE id='$arcId' AND mainid = '$lang'");
    if($rs > 1){
        $classid = $rs['classid'];
    }else{
        return "文档不存在[ID:$arcId]";
    }
    //获取上一篇信息
    $s = "
        SELECT id,classid,title FROM `#@__$tableName`
        WHERE classid='$classid'
        AND id>'$arcId'
		  AND mainid = '$lang'
        AND delstate=''
        AND checkinfo=true
        ORDER BY orderid
        LIMIT 1
    ";
    $r = $dosql->GetOne($s);
    if(empty($r)){
        $html .= '<li>上一篇：已经没有了</li>';
    }else{
        if($cfg_isreurl!='Y'){
            $gourl = $scriptName.'.php?cid='.$r['classid'].'&id='.$r['id'];
        }else{
            $gourl = $scriptName.'-'.$r['classid'].'-'.$r['id'].'-1.html';
        }
        $html .= '<li>上一篇：<a href="'.u($gourl).'">'.$r['title'].'</a></li>';
    }
    
    //获取下一篇信息
    $s = "
        SELECT id,classid,title FROM `#@__$tableName`
        WHERE classid='$classid'
        AND id<'$arcId'
		  AND mainid = '$lang'
        AND delstate=''
        AND checkinfo=true
        ORDER BY orderid DESC
        LIMIT 1
    ";
    $r = $dosql->GetOne($s);
    if(empty($r)){
        $html .= '<li>下一篇：已经没有了</li>';
    }else{
        if($cfg_isreurl!='Y'){
            $gourl = $scriptName.'.php?cid='.$r['classid'].'&id='.$r['id'];
        }else{
            $gourl = $scriptName.'-'.$r['classid'].'-'.$r['id'].'-1.html';
        }
        $html .= '<li>下一篇：<a href="'.u($gourl).'">'.$r['title'].'</a></li>';
    }
    return $html;
}
function pn($arcId = 0,$tableName='infolist'){
	return GetPN($arcId,$tableName); // pn:PreAndNext
}



// 用于语言切换时的 select 的 selected
// $type:option,a
function isCurLang($langId = 1,$type = 'a'){
	if (!isset($_GET['lang'])) return;
	$lang = (int)$_GET['lang'];
	if ($lang == $langId){
		if ('option' == $type){
			return ' selected="selected" ';
		}else{
			return ' class="hover" ';
		}
	}
}

// 为网址添加语言参数"&lang=x"
function GetLangUri($url = ''){
	global $lang,$cfg_maintype;
	if ('N'==$cfg_maintype)return $url;
	if (!isset($lang)) return $url;
	if (empty($url)) $url = $_SERVER['REQUEST_URI'];
	$langArray = array();
	// 过滤掉URI中的lang参数后重新生成URI（悲哀，不熟悉正则）
	$paramArray = array();
	$pathParts = parse_url($url);
	$scriptName = $pathParts['path'];
	$queryString = isset($pathParts['query']) ? $pathParts['query'] : '';
	$queryStringArray = explode('&',$queryString);
	foreach ($queryStringArray as $v){
		if (FALSE === strpos($v,'lang=')) $paramArray[] = $v;
	}
	if (!empty($paramArray)){
		$queryString = implode('&',$paramArray);
		$uri = $scriptName.'?'.$queryString.'&lang='.$lang;
	}else{
		$uri = $scriptName.'?lang='.$lang;
	}
	return $uri;
}
function u($url = ''){
	return GetLangUri($url);
}

// 语言切换的 options
// $type:option/a/li
function GetLangHtml($type = 'option'){
	global $dosql;
	$langArray = array();
	// 过滤掉URI中的lang参数后重新生成URI（悲哀，不熟悉正则）
	$paramArray = array();
	$scriptName = $_SERVER['SCRIPT_NAME'];
	$queryString = $_SERVER['QUERY_STRING'];
	$queryStringArray = explode('&',$queryString);
	foreach($queryStringArray as $i => $v){
		if($v == '') unset($queryStringArray[$i]);
	}
	 foreach ($queryStringArray as $v){
		if (FALSE === strpos($v,'lang=')) $paramArray[] = $v;
	 }
	 if (!empty($paramArray)){
		 $queryString = implode('&',$paramArray);
		 $uri = $scriptName.'?'.$queryString.'&lang=';
	 }else{
		 $uri = $scriptName.'?lang=';
	 }
	 // 详细页输出首页的URI
	 if (FALSE !== strpos($scriptName,'show.php')) $uri = 'index.php?lang=';
	 if (FALSE !== strpos($scriptName,'info.php')) $uri = 'index.php?lang=';
	 if (FALSE !== strpos($scriptName,'article_')) $uri = 'index.php?lang=';
	 
	 // options
	 $s = "
	 	SELECT id,classname
		FROM `#@__maintype`
		WHERE checkinfo = true
		ORDER BY orderid ASC
	 ";
    $q = $dosql->Execute($s,'langList');
    while($rs = $dosql->GetArray('langList')){
		 $langId = $rs['id'];
		 $langName = $rs['classname'];
		 $langArray[$langId] = $langName;
	 }
	 // 按指定格式输出
	 $html = '';
	foreach($langArray as $k => $v){
		 switch($type){
			 case 'option':
				$html .= "<option value=\"$uri$k\" ".isCurLang($k,'option').">$v</option>";
				break;
			case 'li':
				$html .= "<li><a href=\"$uri$k\" ".isCurLang($k)." title=\"$v\">$v</a></li>";
				break;
			default:
				$html .= "<a href=\"$uri$k\" ".isCurLang($k)." title=\"$v\">$v</a> ";
		 }
	}
	 return $html;
}
// 获取栏目信息
function GetCateInfo($cid = 0, $field = 'classname', $table = 'infoclass'){
	global $dosql;
	if (empty($cid))return 'Err:NeedCid.';
	$cid = (int)$cid;
	$s = "
		SELECT $field
		FROM `#@__$table`
		WHERE id = '$cid'
	";
	$rs = $dosql->GetOne($s);
	return empty($rs[$field]) ? '' : $rs[$field];
}
function c($cid = 0, $field = 'classname', $table = 'infoclass'){
	return GetCateInfo($cid, $field, $table);
}

/**
 * 输出栏目形式的导航菜单
 * linkurl 要写到栏目自身的属性里，此菜单不使用“菜单功能”，直接使用栏目
 */
function	GetNavi($pid= 0,$showSubElm = FALSE,$homePageName = '首页'){
	global $dosql,$lang;
	$html = '<li class="naviFirst"><a href="'.GetLangUri('index.php').'">'.translate($homePageName,$lang).'</a></li>';
	$s = "
		SELECT id,classname,linkurl
		FROM `#@__infoclass`
		WHERE parentid = '$pid'
		AND checkinfo = true
		ORDER BY orderid ASC
	";
	$q = $dosql->Execute($s,'navi');
	while($rs = $dosql->GetArray('navi')){
		// 是显示下级菜单
		$r = array();
		if (TRUE == $showSubElm){
			$cateId = $rs['id'];
			$r = $dosql->GetOne("SELECT COUNT(id) AS total FROM `#@__infoclass` WHERE parentid = '$cateId'");
		}
		if (0 == count($r)){
			$html .= '<li><a href="'.GetLangUri($rs['linkurl']).'">'.translate($rs['classname'],$lang).'</a></li>';
		}else{
			$s = "
				SELECT id,classname,linkurl
				FROM `#@__infoclass`
				WHERE parentid = '$cateId'
				AND checkinfo = true
				ORDER BY orderid ASC
			";
			$q = $dosql->Execute($s,'subNavi');
			$html .= '
			<li><a href="'.GetLangUri($rs['linkurl']).'">'.translate($rs['classname'],$lang).'</a>
				<ul class="subNavi">';
			while($r = $dosql->GetArray('subNavi')){
				$html .= '<li><a href="'.GetLangUri($r['linkurl']).'">'.translate($r['classname'],$lang).'</a></li>';
			}
			$html .= '
				</ul>
			</li>';
		}
	}
	return $html;
}
function navi($pid= 0,$showSubElm = FALSE,$homePageName = '首页'){
	return GetNavi($pid,$showSubElm,$homePageName);
}

/**
 * 以 dl 格式输出产品类别树
 * dd 中以 ul 的 li形式输出
 */
function	GetCateTree($pid= 0,$showSubElm = TRUE){
	global $dosql,$lang;
	$html = '';
	$s = "
		SELECT id,classname,linkurl
		FROM `#@__infoclass`
		WHERE parentid = '$pid'
		AND checkinfo = true
		ORDER BY orderid ASC
	";
	$q = $dosql->Execute($s,'navi');
	while($rs = $dosql->GetArray('navi')){
		// 是显示下级菜单
		$r = array('total'=>0);
		if (TRUE == $showSubElm){
			$cateId = $rs['id'];
			$r = $dosql->GetOne("SELECT COUNT(id) AS total FROM `#@__infoclass` WHERE parentid = '$cateId'");
		}
		if (0 == $r['total']){
			$html .= '
				<dt class="categoryName">
					<a href="'.GetLangUri($rs['linkurl']).'">'.translate($rs['classname'],$lang).'</a>
				</dt>
			';
		}else{
			$html .= '
				<dt>
					<a href="'.GetLangUri($rs['linkurl']).'">'.translate($rs['classname'],$lang).'</a>
				</dt>
				<dd>
					<ul>
			';
			$s = "
				SELECT id,classname,linkurl
				FROM `#@__infoclass`
				WHERE parentid = '$cateId'
				AND checkinfo = true
				ORDER BY orderid ASC
			";
			$q = $dosql->Execute($s,'subNavi');
			while($r = $dosql->GetArray('subNavi')){
				$html .= '<li><a href="'.GetLangUri($r['linkurl']).'">'.translate($r['classname'],$lang).'</a></li>';
			}
			$html .= '
				</ul>
			</dd>';
		}
	}
	return $html;
}
function ct($pid= 0,$showSubElm = TRUE){
	return GetCateTree($pid,$showSubElm);
}
?>
