// 动态扩展字段中涉及到的JS信息

/** 这一部分都是图片相关的JS操作 **/
//弹出图片选择器窗口
function phpjs_img(input_id,view_id)
{
	var extend = "type=img&input="+input_id+"&view="+view_id;
	var url = get_url("open",extend);
	Layer.init(url,550,400);
	return true;
}

//删除图片
function phpjs_clear_img(input_id,view_id)
{
	getid(input_id).value = "";
	getid(view_id).innerHTML = "<img src='img/nopic.gif' />";
	return true;
}

/****这一部分都是视频的操作******/
//弹出视频选择器
function phpjs_video(input_id,view_id)
{
	var extend = "type=video&input="+input_id+"&view="+view_id;
	var url = get_url("open",extend);
	Layer.init(url,550,400);
	return true;
}


//删除视频选择
function phpjs_clear_video(input_id,view_id)
{
	getid(input_id).value = "";
	getid(view_id).innerHTML = "";
	return true;
}


/** 这一部分是下载的操作 *****/
//弹出下载选择窗口
function phpjs_download(input_id,view_id)
{
	var extend = "type=download&input="+input_id+"&view="+view_id;
	var url = get_url("open",extend);
	Layer.init(url,550,400);
	return true;
}
//删除文件下载选择
function phpjs_clear_download(input_id,view_id)
{
	getid(input_id).value = "";
	getid(view_id).innerHTML = "";
	return true;
}

//预览窗口
function phpjs_preview(id,pretype)
{
	var extend = "id="+id+"&";
	if(pretype && pretype != "undefined")
	{
		extend += "pretype="+pretype+"&";
	}
	var url = get_url("open,preview",extend);
	Layer.init(url,550,400);
	return true;
}

//通过通过Ajax存储相关信息
function phpjs_parent_opt(val,id,fid)
{
	if(!id || id == "undefined")
	{
		return false;
	}
	
	var extend = "fid="+fid+"&";
	getid(id).value = val;
	if(val && val != "undefined")
	{
		extend += "val="+EncodeUtf8(val)+"&";
	}
	var url = get_url("datalink,ajax_opt",extend);
	var msg = ajax_get(url);
	if(!msg)
	{
		alert("操作有误");
		return false;
	}
	var array = JSON.parse(msg);
	if(array["error"])
	{
		getid("_opt_parent_"+id).innerHTML = array["error"];
		return true;
	}
	if(array["parent"] && array["parent"] != "undefined")
	{
		getid("_opt_parent_"+id).innerHTML = array["parent"];
	}
	if(array["son"] && array["son"] != "undefined")
	{
		getid("_opt_son_"+id).innerHTML = array["son"];
	}
	else
	{
		getid("_opt_son_"+id).innerHTML = "";
	}
	return true;
}

function phpjs_son_opt(val,id)
{
	getid(id).value = val;
	return true;
}
//通过通过Ajax存储相关信息
function phpjs_parent_becate(val,id,fid)
{
	if(!id || id == "undefined")
	{
		return false;
	}
	var extend = "fid="+fid+"&";
	getid(id).value = val;
	if(val && val != "undefined")
	{
		extend += "val="+EncodeUtf8(val)+"&";
	}
	var url = get_url("list,ajax_becate",extend);
	var msg = ajax_get(url);
	if(!msg)
	{
		alert("操作有误");
		return false;
	}
	var array = JSON.parse(msg);
	if(array["error"])
	{
		getid("_opt_parent_"+id).innerHTML = array["error"];
		return true;
	}
	if(array["parent"] && array["parent"] != "undefined")
	{
		getid("_opt_parent_"+id).innerHTML = array["parent"];
	}
	else
	{
		getid("_opt_parent_"+id).innerHTML = "";
	}
	return true;
}
function phpjs_son_becate(val,id)
{
	getid(id).value = val;
	return true;
}
//通过通过Ajax存储相关信息
function phpjs_parent_bemod(val,id,fid)
{
	if(!id || id == "undefined")
	{
		return false;
	}
	var extend = "fid="+fid+"&";
	getid(id).value = val;
	if(val && val != "undefined")
	{
		extend += "val="+EncodeUtf8(val)+"&";
	}
	var url = get_url("list,ajax_bemod",extend);
	var msg = ajax_get(url);
	if(!msg)
	{
		alert("操作有误");
		return false;
	}
	var array = JSON.parse(msg);
	if(array["error"])
	{
		getid("_opt_parent_"+id).innerHTML = array["error"];
		return true;
	}
	if(array["parent"] && array["parent"] != "undefined")
	{
		getid("_opt_parent_"+id).innerHTML = array["parent"];
	}
	else
	{
		getid("_opt_parent_"+id).innerHTML = "";
	}
	return true;
}
function phpjs_son_bemod(val,id)
{
	getid(id).value = val;
	return true;
}

//Fck编辑器用到的JS，图片
function phpjs_fck_img(id)
{
	var extend = "fck_id="+id+"&type=img";
	var url = get_url("open,fck",extend);
	//判断是否使用可视化编辑器
	var Editor = FCKeditorAPI.GetInstance(id);
	var EditorType = FCK_EDITMODE_WYSIWYG;
	if(Editor.EditMode != EditorType)
	{
		alert("请取消源码查看，使用可视化编辑器");
		return false;
	}
	Layer.init(url,550,400);
	return true;
}
//Fck编辑器用到的JS，下载
function phpjs_fck_download(id)
{
	var extend = "fck_id="+id+"&type=download";
	var url = get_url("open,fck",extend);
	//判断是否使用可视化编辑器
	var Editor = FCKeditorAPI.GetInstance(id);
	var EditorType = FCK_EDITMODE_WYSIWYG;
	if(Editor.EditMode != EditorType)
	{
		alert("请取消源码查看，使用可视化编辑器");
		return false;
	}
	Layer.init(url,550,400);
	return true;
}
//Fck编辑器用到的JS，视频
function phpjs_fck_video(id)
{
	var extend = "fck_id="+id+"&type=video";
	var url = get_url("open,fck",extend);
	//判断是否使用可视化编辑器
	var Editor = FCKeditorAPI.GetInstance(id);
	var EditorType = FCK_EDITMODE_WYSIWYG;
	if(Editor.EditMode != EditorType)
	{
		alert("请取消源码查看，使用可视化编辑器");
		return false;
	}
	Layer.init(url,550,400);
	return true;
}

//扩展模块数据预览，图片
function phpjs_viewpic(n_vid,input)
{
	var input_view = "_view_"+input;
	if(!n_vid || n_vid =="" || n_vid == "undefined")
	{
		getid(input_view).innerHTML = "<img src='img/nopic.gif' />";
		return true;
	}
	var url = get_url('open,ajax_preview_img')+"idstring="+n_vid;
	var msg = get_ajax(url);
	if(msg == "empty")
	{
		phpjs_viewpic("",input_view);
		return true;
	}
	var array = JSON.parse(msg);
	var length_array = array.length;
	//通过Ajax获取图片列表
	var p_html = '<table><tr>';
	for(var i=0;i<length_array;i++)
	{
		var tmp_i = i+1;
		var srcurl = array[i]["url"];
		if(!srcurl || srcurl == "" || srcurl == "undefined")
		{
			srcurl = "img/nopic.gif";
		}
		p_html += '<td><img src="'+srcurl+'" class="hand" onclick="phpjs_preview(\''+array[i]["id"]+'\')" /></td>';
		if(tmp_i%8 == "")
		{
			p_html += "</tr><tr>";
		}
	}
	p_html += "</tr></table>";
	getid(input_view).innerHTML = p_html;
	return true;
}
//扩展模块数据预览，下载
function phpjs_viewdown(id,input)
{
	var input_view = "_view_"+input;
	if(!id || id == "" || id == "undefined")
	{
		return false;
	}
	var viewhtml = '<input type="button" value="详情" class="button" onclick="phpjs_preview(\''+id+'\',\'download\')"> 附件ID：'+id+' <img src="img/download.gif" align="absmiddle" /> ';
	getid(input_view).innerHTML = viewhtml;
	return true;
}
//扩展模块数据预览，影音
function phpjs_viewvideo(id,input)
{
	var input_view = "_view_"+input;
	if(!id || id == "" || id == "undefined")
	{
		return false;
	}
	var viewhtml = '<input type="button" value="预览" class="button" onclick="phpjs_preview(\''+id+'\')"> 影音ID：'+id+' <img src="img/video.gif" align="absmiddle" /> ';
	getid(input_view).innerHTML = viewhtml;
	return true;
}

//单图按钮
function phpjs_onepic(vid)
{
	var extend = "input="+vid;
	var url = get_url("open,img",extend);
	Layer.init(url,550,400);
	return true;
}

function phpjs_onepic_view(vid)
{
	var url = getid(vid).value;
	if(!url)
	{
		alert("没有相关图片信息！");
		return false;
	}
	Layer.init(url,550,400);
	return true;
}

function phpjs_onepic_clear(vid)
{
	getid(vid).value = "";
	return true;
}
