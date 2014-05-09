// JavaScript Document
$(document).ready(function(){
	//列表HOVER
	$(".CasesList li, .TeamList li, .ReservaList li, .FaqList li, .Guard li").hover(function(){$(this).addClass("hover")},function(){$(this).removeClass("hover")});
    //input background
	$(".table input[type='text'],.table textarea").focus(function(){$(this).css({'border':'1px solid #009DBE','background':'#fff'})})
								  .blur(function(){$(this).css({'border':'1px solid #DDD','background':'#fff'})});
});
//浮动
$(document).ready(function(){
	var s=$('.SideBox').offset().top;
	$(window).scroll(function(){$(".SideBox").animate({top:$(window).scrollTop()+s+"px"},{queue:false,duration:500})});
	$body=(window.opera)?(document.compatMode=="CSS1Compat"?$('html'):$('body')):$('html,body');
	$(".SideBox .BackTop").click(function(){$('html,body').animate({scrollTop: '0px'}, 2000);});
});
//业主评价及专题活动背景动画Hover
$(document).ready(function() {
	$(".ThinkList li").hover(function(){
		$(this).addClass('hover');
		$(this).find(".time").stop().animate({backgroundPosition:"-165px -210px"},1000);
		$(this).find("i").stop().animate({backgroundPosition:"-120px -180px"},500);
	},function(){
		$(this).removeClass('hover');
		$(this).find(".time").stop().animate({backgroundPosition:"-165px -330px"},500);
		$(this).find("i").stop().animate({backgroundPosition:"-120px -226px"},1000);
	}); 
});