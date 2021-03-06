//获取列表
function GetList(par_tbn, par_tid, par_cut)
{
	pag     = par_tbn;
	tbn     = par_tbn;
	tid     = par_tid;
	cut     = par_cut;
	flag    = "all";
	keyword = "";
	page    = 1;

	$.ajax({
		url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("body").append('<div id="listload"></div><div id="coverbg"></div>');
			$("#coverbg").css("height",$(document).height()).show();
		},
		success:ShowList
	});
}


//输出列表
function ShowList(data, textStatus, xmlHttp)
{
	$("#list_area").html(data);
	$("#coverbg").hide();
}


//输出列表
function GetDone(data, textStatus, xmlHttp)
{
	$("#list_area").html(data);
	$("#coverbg").hide();
	$("#listload").hide();
}


//选择分类函数
function GetType(par_tid, classname)
{
	tid = par_tid;
	$(".alltype .btn").html(classname);

	$.ajax({
		url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#coverbg").css("height",$(document).height()).show();
			$("#listload").show();
		},
		success:GetDone
	});
}


//显示属性
function GetFlag(par_flag)
{
	flag = par_flag;
	$.ajax({
		url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#coverbg").css("height",$(document).height()).show();
			$("#listload").show();
		},
		success:GetDone
	});
}


//显示查询列表
function GetSearch()
{
	var keyword = $("#keyword").val();
	if(keyword == '' || keyword == '请填写关键字')
	{
		$("#keyword").val("请填写关键字");
		return;
	}

	$.ajax({
		url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut+"&keyword="+encodeURI(keyword),
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#coverbg").css("height",$(document).height()).show();
			$("#listload").show();
		},
		success:GetDone
	});

	$("#list_load").css({"display":"block"});
}


//显示分页
function PageList(par_page)
{
	page = par_page;

	$.ajax({
		url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut+"&keyword="+encodeURI(keyword)+"&page="+page,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#coverbg").css("height",$(document).height()).show();
			$("#listload").show();
		},
		success:GetDone
	});
}


//删除信息
function ClearInfo(par_id)
{
	if(confirm("确定要删除选中的信息吗？"))
	{
		$.ajax({
			url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut+"&keyword="+encodeURI(keyword)+"&page="+page+"&action=del&id="+par_id,
			type:'get',
			dataType:'html',
			success:GetDone
		});
	}
	else
	{
		return false;
	}
}


//删除信息
function AjaxClearAll()
{
	var ckobj = $("input[type='checkbox'][name!='checkid'][name^='checkid']:checked");

	if(ckobj.size() > 0)
	{
		if(confirm("确定要删除选中的信息吗？"))
		{
			var ids = '';
	
			ckobj.each(function(){
				if($(this).val() != 'on'){
					ids += $(this).val() + ',';
				}
			});
		
			ids = ids.slice(0,-1);
		
			$.ajax({
				url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut+"&keyword="+encodeURI(keyword)+"&page="+page+"&action=delall&ids="+ids,
				type:'get',
				dataType:'html',
				success:GetDone
			});
		}
		else
		{
			return false;
		}
	}
	else
	{
		alert('没有任何选中信息！');
		return false;
	}
}


//更改审核状态
function CheckInfo(par_id,state)
{
	id = par_id;
	$.ajax({
		url : tbn+"_save.php?action=check&id="+id+"&checkinfo="+encodeURI(state),
		type:'get',
		dataType:'html',
		success:function(data){$("#check"+id).html(data);}
	});
}


/******************************* 回收站 *******************************/


//显示回收站
function ShowRecycle()
{
	$.ajax({
		url : "recycle_mini.php?type="+tbn,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#coverbg").css("height",$(document).height()).show();
			$("#listload").show();
			$("#recycle_window").show();
			$("#recycle_list").html('<div class="loading" style="text-align:center;margin-top:75px;"><img src="templets/images/loading.gif">列表加载中...</div>');
		},
		success:RecycleDone
	});
}


//隐藏回收站
function HideRecycle()
{
	$.ajax({
		url : pag+"_do.php?tbname="+tbn+"&tid="+tid+"&flag="+flag+"&fromurl="+cut+"&keyword="+encodeURI(keyword)+"&page="+page,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#recycle_window").hide();
			$("#coverbg").css("height",$(document).height()).show();
			$("#listload").show();
		},
		success:GetDone
	});
}


//回收站内容操作
function RecycleRe(action,id)
{
	$.ajax({
		url : "recycle_mini.php?type="+tbn+"&action="+action+"&id="+id,
		type:'get',
		dataType:'html',
		success:RecycleDone
	});
}


//操作所有
function RecycleReAll(action)
{
	var ids = '';

	$("#recycleform input[type='checkbox'][id^='recycle_checkid']:checked").each(function(){
		ids += $(this).val() + ',';
	});

	ids = ids.slice(0,-1);

	$.ajax({
		url : "recycle_mini.php?type="+tbn+"&action="+action+"&ids="+ids,
		type:'get',
		dataType:'html',
		success:RecycleDone
	});
}


//完成操作
function RecycleDone(data)
{
	$("#recycle_list").html(data);
}
