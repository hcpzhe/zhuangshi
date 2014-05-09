// JavaScript Document
/*
$(document).ready(function(){
	var Interval = 4000;//自动轮换间隔时间
	var speed = 800;//切换速度
    var curr = 0;
    var imgLen=$('.iPlayer .ImgBox').find('li').length;
	var imgWidth=$('.iPlayer .ImgBox').find('li').width();

	$('.iPlayer .ImgLen a').each(function(i){
		$(this).click(function(){
			curr = i;
			$(this).siblings('a').removeClass('hover').end().addClass('hover');
			$('.iPlayer .ImgBox ul').width(imgLen * imgWidth);
			var item_len=$('.iPlayer .ImgBox').find('li').innerWidth(true);
			$('.iPlayer .ImgBox ul').animate({"marginLeft":"-"+item_len*i+"px"},{duration:speed,queue:false});
			var style = $('.iPlayer .ImgBox a').eq(i).attr("style");
			$('.iPlayer').css("background-color",style);
			return false;
		});
	});
	//鼠标悬停在触发器上时停止自动翻
	$('.iPlayer .ImgBox').hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			todo = (curr + 1) % imgLen;
			$('.iPlayer .ImgLen a').eq(todo).click();
		},Interval);		
	}).trigger('mouseleave');
	$('.iPlayer .ImgLen a').eq(0).click();
});
*/

$(document).ready(function(){
	var Interval = 4000;//自动轮换间隔时间
	var speed = 800;//切换速度
    var curr = 0;
    var imgLen=$('.iPlayer .ImgBox').find('li').length;

	$('.iPlayer .ImgLen a').each(function(i){
		$(this).click(function(){
			curr = i;
			$(this).siblings('a').removeClass('hover').end().addClass('hover');
			$('.iPlayer .ImgBox li').eq(i).fadeIn('slow').siblings('li').hide();
			return false;
		});
	});
	//鼠标悬停在触发器上时停止自动翻
	$('.iPlayer .ImgBox').hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			todo = (curr + 1) % imgLen;
			$('.iPlayer .ImgLen a').eq(todo).click();
		},Interval);		
	}).trigger('mouseleave');
	
	$('.iPlayer .ImgLen a').eq(0).click();
});


$(document).ready(function(){
	//HOVER
	$(".iCases li, .iTeam .li, .iCus, .iThink li, .iRes li, .iBuild .imga,.iMater li").hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover")});
	$(".iCus a").hover(function(){$(this, ".iCus").addClass("hover");},function(){$(this, ".iCus").removeClass("hover")});
	//设计团队
	$("#iTeam").jCarouselLite({
	  auto:4000,
	  visible: 4,
	  scroll: 4,
	  speed:2000,
	  btnNext: ".iTprev",
	  btnPrev: ".iTnext"
    }).trigger('mouseleave');
	//视频样板房/户型解析iTab
	$(".iTab .ht cite").hover(function(){
		$(this).addClass("hover").siblings().removeClass("hover");
		var index = $(this).index();
		$(this).parent().siblings("ul").eq(index).show().siblings("ul").hide();
	});
	//在建工地滚动
	var _wrap=$('.iRes ul');
	var _interval=2000;
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
